<?php

session_start();
include'koneksi.php';

$error = "";
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $username =  trim ($_POST ['username']);
    $password =  $_POST ['password'];

    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username ,$password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows ===1) {
        $num = $result->fetch_assoc();
        $_SESSION['username'] =$row['username'];
        $_SESSION['level']    =$row['level'];

        if ($row ['level'] == "admin") {
            header ("Location: dashboard_admin.php");
        } elseif ($row ['level'] == "user") {
            header ("Location: dashboard_user.php");
        } else { 
            $error = "Level tidak dikenali!";
        }
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="" method="post">
        <div class="login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" values="Login">
        </div>
    </form>
</body>
</html>