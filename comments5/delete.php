<?php
include "includes/db.php";

$id = $_GET['id'];

delete($id, $connection);

addMessage('ok', 'Комментарий успешно удален!');

redirect();

/*echo '<pre>';
print_r($_GET);*/