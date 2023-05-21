<?php
session_start();
$user_name = $_SESSION['name'] ?? null;
$user_id   = $_SESSION['user_id'] ?? null;
$is_auth   = !empty($_SESSION);