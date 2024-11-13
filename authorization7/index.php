<?php

include 'includes/db.php';

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
    <title>Authorization7</title>
</head>
<body>
<div class="form-box">
    <form class="my-form" method="post" action="includes/signin.php">
        <label>Login</label>
        <input class="form-control" type="text" name="login" placeholder="login...">
        <label>Password</label>
        <input class="form-control" type="password" name="password" placeholder="password...">
        <label>Email</label>
        <!--<input class="form-control" type="email" name="email" placeholder="email...">-->
        <button class="btn btn-primary" type="submit">Enter</button>
        <p>У вас нет аккаунта?<a href="register.php">Зарегестрируйтесь</a></p>
        <p>Редактируйте профиль<a href="redaction.php">Редактировать</a></p>
    </form>
</div>
<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo '<p style="background-color: blueviolet" class="msg">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}
?>

</body>
</html>
















