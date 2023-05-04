<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

if ($is_auth) {
    header("Location: /");
    exit();
}

$page_content   = include_template('guest.php', []);
$layout_content = include_template(
    'layout.php',
    [
        'title' => 'doing is done title',
        'content' => $page_content
    ]
);
print($layout_content);