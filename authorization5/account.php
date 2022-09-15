<?php
session_start();
 ?>

<h1>Вы залогинились: <?php echo $_SESSION['userlogin'];?> (<?php echo ($_SESSION['is_admin']) ? 'is Admin' : 'not Admin';?>), status: <?php echo $_SESSION['userstatus']?> </h1>

<a href="logout.php">Exit</a>
































