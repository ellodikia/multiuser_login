<?php
session_start();
include 'koneksi.php';

$error = '';
$success = '';

if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']) ?? '';
    $password = $_POST['password'] ?? '';
    $level = $_POST['level'] ?? '';

    // cek apakah username sudah ada
    $cek = $koneksi->prepare("SELECT * FROM users WHERE username=?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows >0){
        $error = "Username sudah digunakan";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $level);
        if($stmt->execute()){
            $success = "Registrasi berhasil silahkan <a href='login.php'>Login</a>";
        } else {
            $error = "Ada kesalahan saat registrasi";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-light), var(--success));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .register-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: var(--white);
            padding: 25px 20px;
            text-align: center;
        }
        
        .register-header h2 {
            font-weight: 600;
            font-size: 28px;
        }
        
        .register-form {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .input-with-icon input, 
        .input-with-icon select {
            padding-left: 45px;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px;
            border: 1px solid #e1e5eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            background: linear-gradient(to right, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 20px;
            color: var(--gray);
        }
        
        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .register-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .error {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            border-left: 4px solid #d32f2f;
        }
        
        .success {
            background-color: #e8f5e9;
            color: #388e3c;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            border-left: 4px solid #388e3c;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Buat Akun Baru</h2>
        </div>
        <div class="register-form">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="level">Level</label>
                    <div class="input-with-icon">
                        <select name="level" required>
                            <option value="users">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">Daftar</button>
            </form>

            <?php if ($success): ?>
                <div class="success"><?= $success ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <div class="register-footer">
                <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
            </div>
        </div>
    </div>
</body>
</html>