-- добавление пользователей
INSERT INTO users (email, password, user_name, register_date)
VALUES ("nwiger@comcast.net", "2U6Hem5Fgv", "Jennie Galaktion", "2020-09-20"),
       ("dkasak@comcast.net", "SV9InmanM9", " Albertina Martinho", "2015-12-20");

-- добавление проектов
INSERT INTO projects (title, author_id)
VALUES ("Входящие", 1),
       ("Учеба", 2),
       ("Работа", 1),
       ("Домашние дела", 2),
       ("Авто", 1);

-- добавление задач
INSERT INTO tasks (creation_date, status, title, file_url, end_date, author_id, project_id)
VALUES ("2021-03-20", 0, "Собеседование в IT компании", "img/lot-1.jpg", "24.03.2023", 1, 3),
       ("2021-03-20", 0, "Выполнить тестовое задание", "img/lot-1.jpg", "25.12.2019", 2, 3),
       ("2021-03-20", 1, "Сделать задание первого раздела", "img/lot-1.jpg", "21.12.2019", 1, 2),
       ("2021-03-20", 0, "Встреча с другом", "img/lot-1.jpg", "22.12.2019", 2, 1),
       ("2021-03-20", 0, "Купить корм для кота", "img/lot-1.jpg", "22.12.2019", 1, 1),
       ("2021-03-20", 0, "Заказать пиццу", "img/lot-1.jpg", "2021-03-23", 2, 4);

-- получить список из всех проектов для одного пользователя;
SELECT * from projects WHERE author_id = 1;

-- получить список из всех задач для одного проекта;
SELECT * FROM tasks WHERE project_id = 1;

-- пометить задачу как выполненную;
UPDATE tasks SET status = 1 WHERE id = 2;

-- обновить название задачи по её идентификатору;
UPDATE tasks SET title = "updated title" WHERE id = 3;
