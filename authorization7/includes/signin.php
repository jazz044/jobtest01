<?php
include 'db.php';

$login = isset($_POST['login']) ? $_POST['login'] : false;
$password = isset($_POST['password']) ? $_POST['password'] : false;

if (!$login or strlen($login) < 2) {
    $_SESSION['message'] = 'Не верный логин или меньше 2ух символов';
    header('Location: /');
    die();
}

if (!$password) {
    $_SESSION['message'] = 'не верный пароль или меньше 2ух символов';
    header('Location: /');
    die();
}

$check_user = mysqli_query($connection, "SELECT * FROM `users` WHERE (email = 'login' or login = 'login') AND `password` = '$password'");

if ($check_user == true)
{
    $_SESSION['message'] = 'Authorization page';
    header('Location: /');
    die();
} else
{
    echo 'Wrong';
}
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo '<p class="msg">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}




