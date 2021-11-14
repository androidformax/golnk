<?php
include_once "includes/functions.php";

if(isset($_POST['link']) && !empty($_POST['link']) && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    if(addLink($_POST['user_id'], $_POST['link'])){
        $_SESSION['success'] = 'Ссылка успешно добавлена!';
    } else {
        $_SESSION['error'] = 'Произошла ошибка при добавлении ссылки, попробуйте еще раз или свяжитесь с администратором';
    }

}

header('Location: profile.php');
die;