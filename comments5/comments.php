<?php
session_start();
include "includes/db.php";

$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : '';
$textarea = (isset($_POST['textarea']) && !empty($_POST['textarea'])) ? $_POST['textarea'] : '';


if (!$name) {
   addMessage('error', 'Вы не заполнили имя');
}

if (!$textarea) {
    addMessage('error', 'Вы не заполнили текст');
}

if ( isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    redirect();
}
//$connection = mysqli_connect("127.0.0.1", 'root', 'root', 'lesson1');

addComments($name, $textarea, $connection);

addMessage('ok', 'Комментарий успешно добавлен');

redirect();