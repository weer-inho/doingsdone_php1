<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $user_id */
/** @var TYPE_NAME $errors */
/** @var TYPE_NAME $con */
/** @var TYPE_NAME $is_auth */
/** @var TYPE_NAME $user_name */

if (!$is_auth) {
    header("Location: /guest.php");
    exit();
}

$projects = get_projects($con);
$project_names = array_column($projects, 'title');
$tasks = get_tasks($user_id, $con);

$page_content   = include_template(
    'addproject.php',
    [
        'projects'            => $projects,
        'tasks'               => $tasks,
    ]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_name = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
    if ($project_name === '') {
        $error = "Название проекта не должно быть пустой строкой!";
    }
    if (in_array($project_name, $project_names)) {
        $error = "Проект с названием '$project_name' уже существует";
    }
    if (isset($error)) {
        $page_content = include_template(
            'addproject.php',
            [
                'projects'      => $projects,
                'tasks'         => $tasks,
                'error'         => $error,
                '$project_name' => $project_name,
            ]
        );
    } else {
        $sql  = get_query_create_project($user_id);
        $stmt = db_get_prepare_stmt($con, $sql, [$project_name]);
        $res  = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /");
        } else {
            $error = mysqli_error($con);
        }
    }
}

$layout_content = include_template(
    'layout.php',
    [
        'title'     => 'doing is done title',
        'content'   => $page_content,
        'user_name' => $user_name,
    ]
);
print($layout_content);