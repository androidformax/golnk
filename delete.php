<?php
include_once "includes/functions.php";
if(!isset($_SESSION['user']['id'])) {
    header('Location: '. getUrl());
    die;
}
if(isset($_GET['id']) || !empty($_GET['id'])) {
    if(isOwnerLink($_GET['id'])) deleteLink($_GET['id']);
}

header('Location: '.getUrl('profile.php'));
die;