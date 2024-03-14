<?php

include 'db.php';

$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

if (!$login || strlen($login) < 2)
{
    $_SESSION['message'] = 'Вы не заполнили имя либо оно меньше 2ух символов';
    header('Location: ../register.php');
    die();
}

if (!$password || strlen($password) < 2)
{
    $_SESSION['message'] = 'Вы не заполнили пароль либо он меньше 2ух символов';
    header('Location: ../register.php');
    die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $_SESSION['message'] = 'Вы не заполнили email адрес';
    header('Location: ../register.php');
    die();
}

$check_email = mysqli_query($connection, "SELECT email FROM `users` WHERE email = '$email'");

if (mysqli_num_rows($check_email))
{
    $_SESSION['message'] = 'Такой пользователь уже зарегестрирован';
    header('Location: ../register.php');
    die();
}

if ($login && $password && $email)
{
    $data = mysqli_query($connection, "INSERT INTO `users`(`login`, `password`, `email`) VALUES ('$login', '$password', '$email')");
    $_SESSION['message'] = 'Регистрация прошла успешно';
    header('Location: ../index.php');
    die();
}else
{
    $_SESSION['message'] = 'Что то не так';
    header('Location: ../register.php');
    die();
}
















