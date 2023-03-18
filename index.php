<?php

require_once('helpers.php');

$show_complete_tasks = rand(0, 1);
$categories = [
    "inbox"    => "Входящие",
    "study"    => "Учеба",
    "work"     => "Работа",
    "homework" => "Домашние дела",
    "auto"     => "Авто",
];
$tasks = [
    [
        "title"              => "Собеседование в IT компании",
        "date_of_completion" => "01.12.2019",
        "category"           => $categories["work"],
        "is_done"            => false,
    ],
    [
        "title"              => "Выполнить тестовое задание",
        "date_of_completion" => "25.12.2019",
        "category"           => $categories["work"],
        "is_done"            => false,
    ],
    [
        "title"              => "Сделать задание первого раздела",
        "date_of_completion" => "21.12.2019",
        "category"           => $categories["study"],
        "is_done"            => true,
    ],
    [
        "title"              => "Встреча с другом",
        "date_of_completion" => "22.12.2019",
        "category"           => $categories["inbox"],
        "is_done"            => false,
    ],
    [
        "title"              => "Купить корм для кота",
        "date_of_completion" => "null",
        "category"           => $categories["homework"],
        "is_done"            => false,
    ],
    [
        "title"              => "Заказать пиццу",
        "date_of_completion" => "null",
        "category"           => $categories["homework"],
        "is_done"            => false,
    ],
];
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
       if ($task["category"] === $category)
           $result++;
    }

    return $result;
}

$page_content = include_template(
    'main.php',
    [
        'show_complete_tasks' => $show_complete_tasks,
        'categories'          => $categories,
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