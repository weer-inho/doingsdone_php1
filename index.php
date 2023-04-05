<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

$project_id = filter_input(INPUT_GET, 'project_id', FILTER_SANITIZE_NUMBER_INT);

if (!$con) {
    $error = mysqli_connect_error();
} else {
    $sql_projects = "SELECT id, title FROM projects";
    $result_projects = mysqli_query($con, $sql_projects);
    if ($result_projects) {
        $projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
    }
}

// получение задач из бд
$sql_tasks    = get_query_list_tasks($user_id);
$result_tasks = mysqli_query($con, $sql_tasks);
if ($result_tasks) {
    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
} else {
    $error = mysqli_error();
}

if ($project_id === '') {
    http_response_code(404);
    echo '<h1>404 error page</h1>';
    die();
}

$page_content   = include_template(
    'main.php',
    [
        'show_complete_tasks' => $show_complete_tasks,
        'projects'            => $projects,
        'tasks'               => $tasks,
        'project_id'          => $project_id
    ]
);
$layout_content = include_template(
    'layout.php',
    [
        'title'   => 'doing is done title',
        'content' => $page_content
    ]
);
print($layout_content);