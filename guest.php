<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $is_auth */

if ($is_auth) {
    header("Location: /");
    exit();
}

$page_content   = include_template('guest.php', []);
$layout_content = include_template(
    'layout.php',
    [
        'title'   => 'Зарегистрироваться',
        'content' => $page_content
    ]
);
print($layout_content);