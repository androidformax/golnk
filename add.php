<?php
include_once "includes/functions.php";

if(!isset($_SESSION['user']['id'])) {
    header('Location: '. getUrl());
    die;
}

if(isset($_POST['link']) && !empty($_POST['link'])) {
    if(addLink($_POST['link'])){
        $_SESSION['success'] = 'Ссылка успешно добавлена!';
    } else {
        $_SESSION['error'] = 'Произошла ошибка при добавлении ссылки, попробуйте еще раз или свяжитесь с администратором';
    }

}

redirectToLink('profile.php');