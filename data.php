<?php
$show_complete_tasks = rand(0, 1);
$categories_old = [
    "inbox"    => "Входящие",
    "study"    => "Учеба",
    "work"     => "Работа",
    "homework" => "Домашние дела",
    "auto"     => "Авто",
];
$tasks_old = [
    [
        "title"              => "Собеседование в IT компании",
        "date_of_completion" => "24.03.2023",
        "category"           => $categories_old["work"],
        "is_done"            => false,
    ],
    [
        "title"              => "Выполнить тестовое задание",
        "date_of_completion" => "25.12.2019",
        "category"           => $categories_old["work"],
        "is_done"            => false,
    ],
    [
        "title"              => "Сделать задание первого раздела",
        "date_of_completion" => "21.12.2019",
        "category"           => $categories_old["study"],
        "is_done"            => true,
    ],
    [
        "title"              => "Встреча с другом",
        "date_of_completion" => "22.12.2019",
        "category"           => $categories_old["inbox"],
        "is_done"            => false,
    ],
    [
        "title"              => "Купить корм для кота",
        "date_of_completion" => "null",
        "category"           => $categories_old["homework"],
        "is_done"            => false,
    ],
    [
        "title"              => "Заказать пиццу",
        "date_of_completion" => "null",
        "category"           => $categories_old["homework"],
        "is_done"            => false,
    ],
];