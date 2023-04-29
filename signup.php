<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $con */
/** @var TYPE_NAME $user_id */

$page_content = include_template(
    'signup.php',
    []
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['email', 'password', 'user_name'];
    $errors   = [];
    $rules    = [
        'email' => function ($email) {
            return validate_email($email);
        },
    ];

    $user = filter_input_array(INPUT_POST, [
        'email'     => FILTER_DEFAULT,
        'password'  => FILTER_DEFAULT,
        'user_name' => FILTER_DEFAULT
    ]);


    foreach ($user as $user_field => $field_value) {
        if (isset($rules[$user_field])) {
            $rule                = $rules[$user_field];
            $errors[$user_field] = $rule($field_value);
        }

        if (in_array($user_field, $required) and $field_value === '') $errors[$user_field] = "Это поле обязательное!";
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template(
            'signup.php',
            [
                'errors' => $errors,
                'user'   => $user,
            ]
        );
    } else {
        $users_data = get_users($con);
        $emails     = array_column($users_data, 'email');
        $names      = array_column($users_data, 'user_name');

        if (in_array($user['email'], $emails)) $errors['email'] = "Данный email уже существует!";
        if (in_array($user['user_name'], $names)) $errors['user_name'] = "Данное имя уже существует!";
        if (count($errors)) {
            $page_content = include_template(
                'signup.php',
                [
                    'errors' => $errors,
                    'user'   => $user,
                ]);
        } else {
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            $sql              = get_query_create_user();
            $stmt             = db_get_prepare_stmt($con, $sql, $user);
            $res              = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Location: /");
            } else {
                $error = mysqli_error($con);
            }
        }
    }
}

$layout_content = include_template(
    'layout.php',
    [
        'title'   => 'doing is done title',
        'content' => $page_content
    ]
);
print($layout_content);