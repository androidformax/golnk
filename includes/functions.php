<?php require_once 'includes/config.php';

function get_url($page = ''){
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

function getUsersCount(){
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

function registerUser($authData){
    if(epmty($authData) || !isset($authData['login']) || empty($authData['login']) || !isset($authData['pass']) || !isset($authData['pass2']) )
        return false;

}