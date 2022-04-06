<?php
$link = mysqli_connect('localhost', 'root', '', 'eplex_db');
mysqli_set_charset($link, 'utf8');

if (!$link) {
    die('Ошибка подключения к БД');
}
