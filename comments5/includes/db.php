<?php
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$connection = mysqli_connect("localhost", 'root', 'root', 'lesson1');

/*if ($connection == false) {
    echo "Error";
}else {
    echo "Good work bro!";
}*/

function addComments($name, $textarea, $connection) {
    $zxc = mysqli_query($connection, "INSERT INTO `comments` (`name`,`textarea`) VALUES ('$name', '$textarea')")  or die(mysqli_error($connection));

}

function delete($id, $connection) {
    $del = mysqli_query($connection, "DELETE FROM `comments` WHERE `id` = {$id}");
}

function redirect ($url = '/') {
    header('Location: ' . $url);
    die();
}
//почему тут вторая скобка []
function addMessage ($type, $text) {
    $_SESSION['message'][] = [
        'type' => $type,
        'text' => $text,
    ];
}