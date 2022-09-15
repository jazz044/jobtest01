<?php
session_start();
unset($_SESSION['userlogin']);
unset($_SESSION['is_admin']);
header('Location: /');