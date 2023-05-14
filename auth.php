<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $user */
/** @var TYPE_NAME $errors */
/** @var TYPE_NAME $con */
/** @var TYPE_NAME $is_auth */

if ($is_auth) {
    header("Location: /");
    exit();
}

$page_content = include_template('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['email', 'password'];
    $errors = [];
    $rules = [
        'email' => function ($email) {
            return validate_email($email);
        },
    ];
    $user = filter_input_array(INPUT_POST, [
        'email'    => FILTER_DEFAULT,
        'password' => FILTER_DEFAULT,
    ]);

    foreach ($user as $task_field => $field_value) if (isset($rules[$task_field])) {
        $rule = $rules[$task_field];
        $errors[$task_field] = $rule($field_value);
        if (in_array($task_field, $required) and empty($field_value)) $errors[$task_field] = "Это поле обязательное!";
    }
    $errors = array_filter($errors);

    $users_data = get_users($con);
    $emails     = array_column($users_data, 'email');
    if (!in_array($user['email'], $emails)) $errors['email'] = "Пользователя с такой почтой не существует";

    if ($errors) {
        $page_content = include_template(
            'auth.php',
            ['user' => $user, 'errors' => $errors]
        );
    } else {
        $user_password = get_password_by_email($con, $user['email']);
        if (!password_verify($user['password'], $user_password)) {
            $errors['password'] = "Неверный пароль";
            $page_content = include_template(
                'auth.php',
                ['user' => $user, 'errors' => $errors]
            );
        } else {
            session_start();
            $_SESSION['name'] = get_name_by_email($con, $user['email']);
            $_SESSION['user_id'] = get_id_by_email($con, $user['email']);
            header("Location: /");
        }
    }
}

$layout_content = include_template(
    'layout.php',
    [
        'title' => 'doing is done title',
        'content' => $page_content
    ]
);
print($layout_content);