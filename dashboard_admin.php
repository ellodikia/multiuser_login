<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin"){
   header (Location: login.php);
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard Admin</title>
</head>
<body>
   <h1>Selamat datang, <?= $_SESSION['username']; ?></h1>
   <p>Anda login sebagai <b>Admin</b></p>
   <p><a href='logout.php'>Logout</a></p>
</body>
</html>