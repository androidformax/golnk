<?php
include_once "functions.php";

if (!isset($_SESSION['user']['id'])) {
    header('Location: '. getUrl());
    die;
}

if(isset($_POST['link_id']) || !empty($_POST['link_id']) && ($_POST['link']) || !empty($_POST['link'])) {
    $link_id = $_POST['link_id'];
    if(isOwnerLink($link_id)) editLink($link_id, $_POST['link']);
}

redirectToLink();