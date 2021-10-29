<?php
include 'includes/config.php';

function get_url($page = ''){
    return HOST . "/" . $page;
}
function connectDB(){
    try{
    return new PDO("mysql:host=" . DB_HOST . "; db_name=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    ]);
    } catch (PDOException $e){
        die();
    }

}

function db_query($sql = ''){
    if(empty($sql)) return false;

    return connectDB()->query($sql);
}
