<?php require_once 'config.php';

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
    $_SESSION['success'] = "Ссылка успешно удалена";
    return db_query("DELETE FROM `links` WHERE `id` = $id;", true);
}

function addLink($link) {
    if(empty($link)) return false;

    $user_id = $_SESSION['user']['id'];
    $short_link = generateShortLink();
    return db_query("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES (NULL, '$user_id', '$link', '$short_link', '0');");
}

function generateShortLink($size = 3){
    $new_string = str_shuffle(URL_CHARS);
    return substr($new_string, 0, $size);
}
function generateShortLink2($size = 3){
    $new_string = '';
    for ($i = 0; $i < $size; $i++) {
        $new_string .= substr(URL_CHARS, rand(0, strlen(URL_CHARS)), 1);
    }
    return $new_string;
}
function getMassage($message='error'){
    $gotmessage='';
    if (isset($_SESSION[$message]) && !empty($_SESSION[$message])) {
        $gotmessage = $_SESSION[$message];
        unset($_SESSION[$message]);
    }
    return $gotmessage;
}

function showMessage($message, $type='danger'){
    if(!empty($message)) {
           echo '<div class="alert alert-'.$type.' alert-dismissible fade show mt-3" role="alert">' . $message;
           echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

function isOwnerLink($link_id){
        if (empty($link_id)) return false;

        if(isset($_SESSION['user']['id'])){
            $user_id = db_query("SELECT `user_id` FROM `links` WHERE `id` = $link_id;")->fetchColumn();

            if($user_id == $_SESSION['user']['id']) return true;
        }
        $_SESSION['error'] = 'Ошибка! Такой ссылки в вашем списке нет, попробуйте удалить ссылку из вашего списка!';
return false;
}

function redirectToLink($link='profile.php'){
    header('Location: '.getUrl($link));
    die;
}

function editLink($link_id, $new_link){
    if(empty($link_id) || empty($new_link)) return false;
    $_SESSION['success'] = "Ссылка успешно отредактирована";

    return db_query("UPDATE `links` SET `long_link` = '$new_link' WHERE `id` = '$link_id';", true);
}