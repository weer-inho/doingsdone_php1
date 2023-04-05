<?php
function count_tasks(array $tasks_array, string $project_id):int {
    $result = 0;

    foreach ($tasks_array as $task) {
        if ($task["project_id"] === $project_id)
            $result++;
    }

    return $result;
}