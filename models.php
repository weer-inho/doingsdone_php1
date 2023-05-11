<?php

/**
 * Формирует SQL-запрос для получения списка задач от определенного пользователя
 * @return string SQL-запрос
 */
function get_query_list_tasks($user_id): string
{
    return "SELECT p.title as project_title, t.status as is_done, t.title, t.end_date, t.project_id FROM tasks t " .
           "JOIN projects p ON t.project_id = p.id " .
           "WHERE t.author_id = $user_id";
}

/**
 * Формирует SQL-запрос для получения списка задач от определенного пользователя
 */
function get_tasks($user_id, $con)
{
    $sql_tasks    = get_query_list_tasks($user_id);
    $result_tasks = mysqli_query($con, $sql_tasks);
    if ($result_tasks) {
        return mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
    }
    else {
        return mysqli_error();
    }
}

/**
 * Формирует подготовленный SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_task($user_id):string {
    return "INSERT INTO tasks (title, project_id, end_date, file_url, author_id, status) VALUES (?, ?, ?, ?, $user_id, 0)";
}

function get_query_create_project($user_id):string {
    return "INSERT INTO projects (title, author_id) VALUES (?, $user_id)";
}

/**
 * Формирует подготовленный SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_user():string {
    return "INSERT INTO users (email, password, user_name, register_date) VALUES (?, ?, ?, NOW())";
}

/**
 * Возвращает массив проектов
 * @param $con Подключение к MySQL
 * @return array $error Описание последней ошибки подключения
 * @return array $categories Ассоциативный массив с проектами
 */
function get_projects($con):array
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        $sql    = "SELECT id, title, title FROM projects";
        $result = mysqli_query($con, $sql);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return mysqli_error();
        }
    }
}

/**
 * Возвращает массив пользователей
 * @param $con Подключение к MySQL
 * @return array $error Описание последней ошибки подключения
 * @return array $categories Массив пользователей
 */
function get_users($con):array
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        $sql    = "SELECT email, user_name FROM users";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $users_data = get_arrow($result);
            return $users_data;
        } else {
            return mysqli_error();
        }
    }
}

function get_password_by_email($con, $email)
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        $sql    = "SELECT password FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $users_data = mysqli_fetch_assoc($result);
            return reset($users_data);
        } else {
            return mysqli_error();
        }
    }
}

function get_name_by_email($con, $email)
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        $sql    = "SELECT user_name FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $users_data = mysqli_fetch_assoc($result);
            return reset($users_data);
        } else {
            return mysqli_error();
        }
    }
}

function get_id_by_email($con, $email)
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        $sql    = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $users_data = mysqli_fetch_assoc($result);
            return reset($users_data);
        } else {
            return mysqli_error();
        }
    }
}

function get_tasks_by_request($con, $request)
{
    if (!$con) {
        return mysqli_connect_error();
    } else {
        //$sql    = "SELECT email, user_name FROM users";
        $sql = "SELECT p.title as project_title, t.status as is_done, t.title, t.end_date, t.project_id FROM tasks t " .
               "JOIN projects p ON t.project_id = p.id " .
               "WHERE MATCH(t.title) AGAINST('$request')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $users_data = get_arrow($result);
            return $users_data;
        } else {
            return mysqli_error();
        }
    }
}

/**
 * Возвращает массив из объекта результата запроса
 * @param object $result_query mysqli Результат запроса к базе данных
 * @return array
 */
function get_arrow($result_query)
{
    $row = mysqli_num_rows($result_query);
    if ($row === 1) {
        $arrow = mysqli_fetch_assoc($result_query);
    } else if ($row > 1) {
        $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
    }

    return $arrow;
}