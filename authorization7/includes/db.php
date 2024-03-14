<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

$connection = mysqli_connect('127.0.0.1', 'root', 'root', 'lesson4');

// if ($connection == false) {
//      echo 'Error';
// }else {
//     echo "good work bro";
//  }



