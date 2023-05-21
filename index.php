<?php
require_once('helpers.php');
require_once('init.php');
require_once('data.php');
require_once('functions.php');
require_once('models.php');

/** @var TYPE_NAME $con */
/** @var TYPE_NAME $user_id */
/** @var TYPE_NAME $is_auth */
/** @var TYPE_NAME $user_name */

if (!$is_auth) {
    header("Location: /guest.php");
    exit();
}

$all_filters         = ['all', 'today', 'tomorrow', 'expired'];
$current_filter      = reset($all_filters);
$show_complete_tasks = false;

$project_id = filter_input(INPUT_GET, 'project_id', FILTER_SANITIZE_NUMBER_INT);
$projects   = get_projects($con);
$tasks      = get_tasks($user_id, $con);
if ($project_id === '') {
    http_response_code(404);
    echo '<h1>404 error page</h1>';
    die();
}

if (isset($_GET['show_completed'])) {
    $show_complete_tasks = boolval(filter_input(INPUT_GET, 'show_completed'));
}

$page_content = include_template(
    'main.php',
    [
        'show_complete_tasks' => $show_complete_tasks,
        'projects'            => $projects,
        'tasks'               => $tasks,
        'filter'              => $current_filter,
        'project_id'          => $project_id,
    ]
);

if (isset($_GET['task_id']) && isset($_GET['check'])) {
    $task_id = filter_input(INPUT_GET, 'task_id');
    $res = change_task_status($con, $task_id);
    if ($res) {
        header("Location: /");
    } else {
        $error = mysqli_error($con);
    }
}
if (isset($_GET['filter']) && in_array($_GET['filter'], $all_filters)) {
    $current_filter = filter_input(INPUT_GET, 'filter');
    $filtered_tasks = filter_tasks($current_filter, $tasks);
    $page_content   = include_template(
        'main.php',
        [
            'show_complete_tasks' => $show_complete_tasks,
            'projects'            => $projects,
            'tasks'               => $filtered_tasks,
            'filter'              => $current_filter,
            'project_id'          => $project_id,
        ]
    );
}
if (isset($_GET['search'])) {
    $search_request = filter_input(INPUT_GET, 'search');
    if (trim($search_request) !== '') {
        $tasks        = get_tasks_by_request($con, $search_request);
        $page_content = include_template(
            'main.php',
            [
                'show_complete_tasks' => $show_complete_tasks,
                'projects'            => $projects,
                'tasks'               => $tasks,
                'filter'              => $current_filter,
                'project_id'          => $project_id,
                'search'              => $search_request,
            ]
        );
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