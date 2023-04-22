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
    foreach ($tasks_array as $task) if ($task["project_id"] === $project_id)
        $result++;

    return $result;
}

function validate_date(string $end_date) {
    if (!is_date_valid($end_date)) return "Дата выполнения должна быть в формате ГГГГ-ММ-ДД";
    $today    = strtotime(date('Y-m-d'));
    $exp_date = strtotime($end_date);
    if ($today < $exp_date) return null;
    else return "Дата выполнения должна быть дальше сегоднящнего дня";
}

function validate_project($project_id, array $project_ids) {
    return in_array($project_id, $project_ids) ? null : "Такой категории не существует";
}

function validate_title($title) {
    return is_string($title) && trim($title) !== '' ? null : "Название задачи не должно быть пустым";
}