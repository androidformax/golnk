<?php
ob_start();
//error_reporting(E_ALL && E_NOTICE);
//ini_set('display_errors', 1);

define ('SITE_NAME', "Shorten your URL for FREE / Бесплатный сокращатель ссылок");
define ('HOST', "https://" . $_SERVER['HTTP_HOST']);
define ('URL_CHARS', "abcdefghijklmnopqrstuvwxyz0123456789-");

const DB_HOST = '127.0.0.1';
const DB_NAME = 'golnk';
const DB_USER = 'root';
const DB_PASS = 'root';

session_start();