<?php require_once 'includes/config.php';

function getUrl($page = ''){
    return HOST . "/" . $page;
}
function connectDB(){
    try{
    return new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8",
        DB_USER, DB_PASS, [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    } catch (PDOException $e){
        die($e->getMessage());
    }
}

function db_query($sql = '', $exec = false){
    if(empty($sql)) return false;
    if($exec){
        return connectDB()->exec($sql);
    }
    return connectDB()->query($sql);
}

function getUserCount(){
    return db_query("SELECT COUNT(id) FROM `users`;")->fetchColumn();
}

function getLinksCount(){
    return db_query("SELECT COUNT(id) FROM `links`;")->fetchColumn();
}
function getSumViews(){
    return db_query("SELECT SUM(views) FROM `links`;")->fetchColumn();
}
function getLinkInfo($url){
    if(empty($url)) return [];
    return db_query("SELECT * FROM `links` WHERE `short_link` = '$url';")->fetch();
}
function getUserInfo($login){
    if(empty($login)) return [];
    return db_query("SELECT * FROM `users` WHERE `login` = '$login';")->fetch();
}
function updateViews($url){
    db_query("UPDATE `links` SET `views` = `views`+1 WHERE `short_link` = '$url';", true);
}

function addUser($login, $pass){
    $password = password_hash($pass, PASSWORD_DEFAULT);
    return db_query("INSERT INTO `users` (`id`, `login`, `pass`) VALUES (NULL, '$login', '$password');", true);
}

function registerUser($authData){
    if(empty($authData) || !isset($authData['login']) || empty($authData['login']) || !isset($authData['pass']) || !isset($authData['pass2'])) return false;

    $user = getUserInfo($authData['login']);
    if(!empty($user)){
        $_SESSION['error'] = "Пользователь '" . $authData['login'] . "' уже существует, выберите другое имя.";
        header('Location: register.php');
        die;
    }
    if($authData['pass']!=$authData['pass2']){
        $_SESSION['error'] = "Пароли не совпадают.";
        header('Location: register.php');
        die;
    }

    if(addUser($authData['login'], $authData['pass'])){
        $_SESSION['success'] = "Регистрация прошла успешно.";
        header('Location: login.php');
        die;
    }

    return true;
}
function login($authData){
    if(empty($authData) || !isset($authData['login']) || empty($authData['login']) || !isset($authData['pass']) || empty($authData['pass'])) {
        $_SESSION['error'] = "Логин или пароль не могут быть пустыми.";
        header('Location: login.php');
        die;
    }
    $user = getUserInfo($authData['login']);
    if(empty($user)){
        $_SESSION['error'] = "Логин или пароль не верны.";
        header('Location: login.php');
        die;
    }
    if(password_verify($authData['pass'], $user['pass'])){
        $_SESSION['user'] = $user;
        header('Location: profile.php');
        die;
    } else {
        $_SESSION['error'] = "Не верный пароль.";
        header('Location: login.php');
        die;
    }

}

function getUserLinks($user_id){
    if(empty($user_id)) return [];
    return db_query("SELECT * FROM `links` WHERE `user_id` = $user_id;")->fetchAll();
}

function deleteLink($id){
    if(empty($id)) return false;
    return db_query("DELETE FROM `links` WHERE `id` = $id;", true);
}