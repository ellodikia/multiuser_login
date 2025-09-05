<?php

include 'koneksi.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $level    = $_POST['level'] ?? '';

    $cek = $koneksi->prepare("SELECT * FROM users WHERE username=?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0){
        $error = "Username sudah digunakan";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $level);
        if ($stmt->execute()){
            $success = "Registrasi berhasil";
        } else {
            $error = "Adakah kesalahan saat registrasi";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <div class="registrasi">
        <form action="" method="post">
            <h2>Daftar</h2>
            <label for="">Username</label>
            <input type="text" name="username" placeholder="Masukkan username"> <br><br>
            <label for="">Password</label>
            <input type="password" name="password" placeholder="Masukkan password"> <br><br>
            <select name="level" id="">
                <option value="" disabled select>Pilih</option>
                <option value="users">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="Daftar">
        </form>
        <?php if($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
        <?php if($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>