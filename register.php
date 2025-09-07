<?php

include 'koneksi.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] = 'POST'){
    $username = trim ($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $level    = $_POST['level'] ?? '';

    $cek = $koneksi->prepare("SELECT * FROM users WHERE username=?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $level);
        if ($stmt->execute()) {
            $success = "Registrasi berhasil";
        } else {
            $error = "Terjadi kesalah saar registrasi";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="register">
        <form action="" method="post">
            <label for="">Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required> <br><br>
            <label for="">Password</label>
            <input type="text" name="password" placeholder="Masukkan password" required> <br><br>
            <select name="level" id="">
                <option value="" disable select>Pilih Level</option>
                <option value="users">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="Daftar">
        </form>
        <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>

        <?php if($success): ?>
            <p class="error"><?= $success ?></p>
        <?php endif; ?>

          <?php if($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>