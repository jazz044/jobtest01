<?php
session_start();

$userlogin = 'admin';
$pass = '123';

$login = isset($_POST['login']) && !empty($_POST['login']) ? $_POST['login'] : false;
$password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;

if ($login && $password) {
    $_SESSION['userlogin'] = $login;
    $_SESSION['is_admin'] = 0;
    $_SESSION['userstatus'] = 'Customer';

    header('Location: /account.php');
    die();
}
if ($userlogin == $login && $pass == $password) {
    $_SESSION['is_admin'] = 1;
    $_SESSION['userstatus'] = 'Admin';
}

$userName = (isset($_SESSION['userlogin'])) ? $_SESSION['userlogin'] : '';



?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="blablabla">
    <meta name="keywords" content="html, css, wordpress">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Comments</title>
</head>
<body>
<form class="my-form" action="" method="post">
    <label>Login</label>
    <input class="form-control" type="text" name="login" placeholder="Login">
    <input class="form-control" type="text" name="password"placeholder="Password">
    <button class="btn btn-info" type="submit">Enter</button>
</form>


</body>
</html>