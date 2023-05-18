<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require('vendor/autoload.php');
require_once('init.php');
require_once ('data.php');
require_once ('models.php');
require_once ('helpers.php');
require_once('config/config.php');

/** @var TYPE_NAME $log */
/** @var TYPE_NAME $pass */
/** @var TYPE_NAME $con */
/** @var TYPE_NAME $mailfrom */

// 1. получаем всех пользователей
$sql   = "select id, user_name, email from users";
$res1  = mysqli_query($con, $sql);
$notes = [];
if ($res1) {
    $users = mysqli_fetch_all($res1, MYSQLI_ASSOC);

    // 2. если пользователей удалось получить - идем циклом по массиву пользователей
    foreach ($users as $user) {
        // 2.1 получаем на каждого пользователя его задачи
        $user_id = $user['id'];
        $tasks   = get_tasks($user_id, $con);

        // 2.2. если у пользователя есть задачи - идем циклом по массиву задач
        if ($tasks) {
            foreach ($tasks as $task) {
                // 2.3. рассчитываем оставшееся время до дедлайна задачи
                $end_date = $task['end_date'];
                $diff     = get_time_left($end_date . "+1 day");

                // 2.4. если до завершения задачи осталось больше нули и меньше 24 часов
                if ($diff >= 0 && $diff <= 24) {
                    // 2.5. добавляем в массив $notes еще одну запись с пользователем, почтой, названием и дедлайном
                    $notes[] = [
                        'user_name' => $user['user_name'],
                        'title'     => $task['title'],
                        'end_date'  => $end_date,
                        'email'     => $user['email']
                    ];
                }
            }
        } else {
            $error = mysqli_error($con);
            print("Ошибка2: $error");
        }
    }
} else {
    $error = mysqli_error($con);
    print("Ошибка1: $error");
}

$mess = [];
// 3. идем циклом по массиву записок
foreach ($notes as $k => $v) {
    // 3.1 форматируем дедлайн в формат день-месяц-год
    $date = date_format(date_create($v['end_date']), 'd-m-Y');

    // 3.2 если в массиве записок несколько сгорающих задач для одного пользователя
    if ($k > 0 && $v['user_name'] === $notes[$k - 1]['user_name']) {
        // 3.3 в одну сообщение запихиваем упоминания нескольких задач
        $mess[$v['user_name']] .= "А также задача «" . $v['title'] . "» на $date.\n";
        $email[$v['user_name']] = $notes[$k - 1]['email'];
    } else {
        // 3.4 если у пользователя только одна задача - одно сообщение с одной задачей
        $mess[$v['user_name']] = "Уважаемый, " . $v['user_name'] . ".\nУ вас запланирована задача «" .
                                 $v['title'] . "» на $date.\n";
        $emailto[$v['user_name']] = $notes[$k]['email'];
    }
}

// 4. настраиваем соединение с smtp-сервером, авторизируемся
$dsn = "smtp://$log:$pass@smtp.yandex.ru:465?encryption=SSL";
$transport = new Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl');
$transport->getAuthMode();

$dsn = "smtp://$log:$pass@smtp.yandex.ru:465?encryption=SSL";
$transport = Transport::fromDsn($dsn);
$mailer = new Mailer($transport);

foreach ($mess as $k => $mes) {
    $mailto = $emailto[$k];

    $email = (new Email())
        ->to("$mailto")
        ->from("$mailfrom")
        ->subject("Уведомление от сервиса «Дела в порядке»")
        ->text("$mes");
    // Отправка сообщения
    $mailer->send($email);
    echo 'отправил: ' . $mailto . PHP_EOL;
}