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

$projects    = get_projects($con);
$project_ids = array_column($projects, 'id');
$tasks = get_tasks($user_id, $con);

$page_content = include_template(
    'add.php',
    ['projects' => $projects, 'tasks' => $tasks]
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['title', 'project_id'];
    $errors   = [];
    $rules    = [
        'end_date'   => function ($end_date) {
            return validate_date($end_date);
        },
        'project_id' => function ($project_id) use ($project_ids) {
            return validate_project($project_id, $project_ids);
        },
        'title'      => function ($title) {
            return validate_title($title);
        },
    ];

    $task = filter_input_array(INPUT_POST, [
        'title'      => FILTER_DEFAULT,
        'project_id' => FILTER_DEFAULT,
        'end_date'   => FILTER_DEFAULT,
    ]);

    foreach ($task as $task_field => $field_value) {
        if (isset($rules[$task_field])) {
            $rule                = $rules[$task_field];
            $errors[$task_field] = $rule($field_value);
            if (in_array($task_field, $required) and empty($field_value)) {
                $errors[$task_field] = "Это поле обязательное!";
            }
        }
    }

    $errors = array_filter($errors);

    if (!empty($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path     = $_FILES['file']['name'];

        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/jpeg") {
            $ext = ".jpg";
        } else if ($file_type === "image/png") {
            $ext = ".png";
        }
        if ($ext) {
            $filename         = uniqid() . $ext;
            $task['file_url'] = "uploads/" . $filename;
            move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $filename);
        } else {
            $errors['file'] = "Допустимые форматы файлов: jpg, jpeg, png";
        }
    }

    if ($errors) {
        $page_content = include_template(
            'add.php',
            [
                'errors'   => $errors,
                'projects' => $projects,
                'tasks'    => $tasks
            ]
        );
    } else {
        $sql  = get_query_create_task($user_id);
        $stmt = db_get_prepare_stmt($con, $sql, $task);
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
        'title'   => 'doing is done title',
        'content' => $page_content
    ]
);
print($layout_content);