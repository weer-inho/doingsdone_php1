<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $con */
/** @var TYPE_NAME $user_id */
/** @var TYPE_NAME $is_auth */

if (!$is_auth) {
    header("Location: /guest.php");
    exit();
}

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
        'project_id'          => $project_id,
    ]
);

if (isset($_GET['task_id']) && isset($_GET['check'])) {
    $res  = change_task_status($con, $_GET['task_id']);
    if ($res) {
        header("Location: /");
    } else {
        $error = mysqli_error($con);
    }
}

if (isset($_GET['search'])) {
    $tasks = get_tasks_by_request($con, $_GET['search']);
    $page_content   = include_template(
        'main.php',
        [
            'show_complete_tasks' => $show_complete_tasks,
            'projects'            => $projects,
            'tasks'               => $tasks,
            'project_id'          => $project_id,
            'search' => $_GET['search']
        ]
    );
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