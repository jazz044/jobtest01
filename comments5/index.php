<?php
    include "includes/db.php";
    $comments = mysqli_query($connection, "SELECT * FROM `comments`");

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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Comments</title>
</head>
<body>
<div class="container">
    <form class="my-form" action="/comments.php" method="POST">
        <lebel class="name">Name</lebel>
        <input class="form-control" type="text" name="name" placeholder="Name">
        <label class="name">Comment</label>
        <textarea class="form-control" name="textarea" placeholder="comment"></textarea>
        <button class="btn btn-warning" type="submit">Send</button>
    </form>
    <?php
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        foreach ($_SESSION['message'] as $message) {
            echo '<p class="msg' . $message['type'] . '">' . $message['text'] . '</p>';
        }
        unset($_SESSION['message']);
    }
    ?>
</div>
<table>

    <?php
    if (mysqli_num_rows($comments))
    {
    while ($item = mysqli_fetch_assoc($comments)) {
    ?>
    <tr class="bigbox">
        <td class="box">
            <div class="username"><?php echo $item['name']?></div>
            <div><div class="comment">Комментарий:</div><?php echo $item['textarea']?></div>
            <div><a class="delete" href="delete.php?id=<?php echo $item['id']?>">Удалить</a></div>
        </td>
    </tr>
   <?php } } ?>
</table>


</body>
