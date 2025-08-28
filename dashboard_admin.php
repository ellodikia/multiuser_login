<?php

session_start();
var_dump($_SESSION);
if (!isset ($_SESSION['username']) || $_SESSION['level'] != 'admin') {
    header ("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Hallo Admin, <?=$_SESSION ['username'];?>!</h1>
    <p>Anda login sebagai <b>Admin</b>.</p>
    <p><a href="login.php">Logout</a></p>
</body>
</html>