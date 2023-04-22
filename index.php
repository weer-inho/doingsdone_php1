<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

$project_id = filter_input(INPUT_GET, 'project_id', FILTER_SANITIZE_NUMBER_INT);
$projects = get_projects($con);
$tasks = get_tasks($user_id, $con);

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