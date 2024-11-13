<?php
include 'db.php';

if (!isset($_SESSION['user_id']))
{
    $_SESSION['message'] = 'Вы не авторизованы';
    header('Location: /redaction.php');
    die();
}

$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

if (!$login || strlen($login) < 2)
{
    $_SESSION['message'] = 'Вы не аполнили имя либо оно меньше двух символов';
    header('Location: /redaction.php');
    die();
}

if (!$password || strlen($login) < 2)
{
    $_SESSION['message'] = 'Вы не заполнили пароль либо он меньше 2ух символов';
    header('Location: /redaction.php');
    die();
}

if (!$email || strlen($email) < 2)
{
    $_SESSION['message'] = 'Вы не заполнили email либо он меньше двух символов';
    header('Location: /redaction.phps');
    die();
}

$zxc = mysqli_query($connection, "UPDATE `users` SET `login` = '$login', `password` = '$password', `email` = '$email'" );

$_SESSION['message'] = 'Ваши данные успешно отредактированы';
header('Location: /');
die();



































