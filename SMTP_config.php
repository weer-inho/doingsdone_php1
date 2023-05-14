<?php

$username = 'keks@phpdemo.ru';
$host = 'smtp.phpdemo.ru';
$port = 25;
$password = 'htmlacademy';
$sender = 'keks@phpdemo.ru';
$transport = (new Swift_SmtpTransport($host, $port))
    ->setUsername($username)
    ->setPassword($password);