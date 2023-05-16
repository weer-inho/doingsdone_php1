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

$sql = "select id, user_name, email from users";
$res1  = mysqli_query($con, $sql);
$notes = [];
if ($res1) {
    $users = mysqli_fetch_all($res1, MYSQLI_ASSOC);
    foreach ($users as $user) {
        $user_id = $user['id'];
        $tasks = get_tasks($user_id, $con);
        if ($tasks) {
            foreach ($tasks as $task) {
                $end_date = $task['end_date'];
                $diff = get_time_left($end_date . "+1 day");
                //echo $task['title']." diff=$diff \n";
                if ($diff >= 0 && $diff <= 24) {
                    $notes[] = [//$user_id => [
                                'user_name' => $user['user_name'],
                                'title' => $task['title'],
                                'end_date' => $end_date,
                                'email' => $user['email']
                                //]
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
foreach ($notes as $k => $v) {
    $date = date_format(date_create($v['end_date']), 'd-m-Y');
    if ($k > 0 && $v['user_name'] === $notes[$k - 1]['user_name']) {
        $mess[$v['user_name']] .= "А также задача «" . $v['title'] . "» на $date.\n";
        $email[$v['user_name']] = $notes[$k - 1]['email'];
    } else {
        $mess[$v['user_name']] = "Уважаемый, " . $v['user_name'] . ".\nУ вас запланирована задача «" .
                                 $v['title'] . "» на $date.\n";
        $emailto[$v['user_name']] = $notes[$k]['email'];
    }
}

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