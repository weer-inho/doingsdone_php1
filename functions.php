<?php

require_once('helpers.php');

/**
 * Получает массив задач и айди конретного проекта. Возвращает число задач по этому проекту
 * @param array $tasks_array Массив задач
 * @param string $project_id Идентификатор проекта, количество задач которого надо посчитать
 * @return int Количество задач по этому проекту
 */
function count_tasks(array $tasks_array, string $project_id):int {
    $result = 0;
    foreach ($tasks_array as $task) {
        if ($task["project_id"] === $project_id) {
            $result++;
        }
    }

    return $result;
}

function validate_date(string $end_date) {
    if (!is_date_valid($end_date)) {
        return "Должна быть в формате ГГГГ-ММ-ДД";
    }
    $today    = strtotime(date('Y-m-d'));
    $exp_date = strtotime($end_date);
    if ($today < $exp_date) {
        return null;
    } else {
        return "Должна быть дальше сегодняшнего дня";
    }
}

function validate_project($project_id, array $project_ids) {
    return in_array($project_id, $project_ids) ? null : "Такой категории не существует";
}

function validate_title($title) {
    return is_string($title) && trim($title) !== '' ? null : "Название задачи не должно быть пустым";
}

function validate_email($email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL) ? "Введите корректный email" : null;
}

/**
 * Filter tasks by date.
 *
 * @param array $tasks The array of tasks with "end_date" field.
 * @param string $date The desired date to filter tasks ('today', 'yesterday', or 'tomorrow').
 * @return array The filtered tasks.
 */
function filter_tasks(string $filter, array $tasks):array {
    if ($filter === 'all') {
        return $tasks;
    }

    $filtered_tasks = [];
    $todayTimestamp = strtotime('today');
    $tomorrowTimestamp = strtotime('tomorrow');

    foreach ($tasks as $task) {
        $endDateTimestamp = strtotime($task['end_date']);

        if ($filter === 'expired' && $endDateTimestamp < $todayTimestamp) {
            $filtered_tasks[] = $task;
        } elseif ($filter === 'today' && $endDateTimestamp === $todayTimestamp) {
            $filtered_tasks[] = $task;
        } elseif ($filter === 'tomorrow' && $endDateTimestamp === $tomorrowTimestamp) {
            $filtered_tasks[] = $task;
        }
    }

    return $filtered_tasks;
}