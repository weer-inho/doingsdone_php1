<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

if (!$con) {
    $error = mysqli_connect_error();
} else {
    $sql_projects = "SELECT title FROM projects";
    $result_projects = mysqli_query($con, $sql_projects);
    if ($result_projects) {
        $projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
    } else {
        $error = mysqli_connect_error();
    }
}

// получение задач из бд
$sql_tasks    = get_query_list_tasks(1);
$result_tasks = mysqli_query($con, $sql_tasks);
if ($result_tasks) {
    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
} else {
    $error = mysqli_error();
}

$page_content = include_template(
    'main.php',
    [
        'show_complete_tasks' => $show_complete_tasks,
        'categories'          => $projects,
        'tasks'               => $tasks
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