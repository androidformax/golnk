<?php
include "includes/functions.php";

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: profile.php');
    die;
}

deleteLink($_GET['id']);
$_SESSION['success'] = "Ссылка успешно удалена";
header('Location: profile.php');
die;