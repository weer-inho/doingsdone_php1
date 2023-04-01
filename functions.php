<?php
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param array $tasks_array Список задач в виде массива
 * @param string $category SQL запрос с плейсхолдерами вместо значений
 *
 * @return int Число задач для переданного проекта (категории задач)
 */
function count_tasks(array $tasks_array, string $category):int {
    $result = 0;

    foreach ($tasks_array as $task) {
        if ($task["project_title"] === $category)
            $result++;
    }

    return $result;
}