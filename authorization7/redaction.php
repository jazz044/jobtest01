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
    <title>Редактирование</title>
</head>
<body>
<form class="my-form" action="includes/redactionaction.php" method="post">
    <input type="hidden" name="id" value="<?php echo isset($_SESSION['user_id']);?>">
    <label>Login</label>
    <input class="form-control" type="text" name="login" placeholder="login...">
    <label>Password</label>
    <input class="form-control" type="password" name="password" placeholder="Password...">
    <label>Email</label>
    <input class="form-control" type="email" name="email" placeholder="Email...">
    <button class="btn btn-info">Redaction</button>

</form>
<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo '<p style="background-color: blueviolet" class="msg">' . $_SESSION['message'] . '</p>';
}
?>

</body>
</html>





































