<?php

// подключение к бд
$con = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($con, 'utf8');