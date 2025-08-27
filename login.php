<?php
session_start();
include 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $rows = $result->fetch_assoc();
        $_SESSION['username'] = $rows['username'];
        $_SESSION['level'] = $rows['level'];

        if ($rows['level'] == "admin") {
            header("Location: dashboard_admin.php");
        } elseif ($rows['level'] == "user") {
            header("Location: dashboard_user.php");
        } else {
            $error = "Level tidak dikenali";
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
    <title>Login</title>
</head>
<body>
    <form action="" method="post">
        <div class="login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="passwod" placeholder="Password" required>
            <input type="submit" value="Login">
        </div>
    </form>
</body>
</html>