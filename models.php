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
