<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');

session_start();
$user_name = $_SESSION['name'] ?? null;
$user_id   = $_SESSION['user_id'] ?? null;
$is_auth   = !empty($_SESSION);