<?php

session_start();
include 'koneksi.php';

$error = "";
if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
    $username =trim($_POST['username'] ?? '');
    $password =$_POST['password'] ?? '';

    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows===1) {
        $row = $result->fetch_assoc();
        $_SESSION ['username'] =$row ['username'];
        $_SESSION ['level'] =$row ['level'];

    if ($row ['level'] =="admin"){
        header ("Location: dashboard_admin.php") ;
    } elseif ($row ['level'] =="users"){
        header ("Location: dashboard_user.php") ;
    } else {
        $error = "Level tidak dikenali";
        } 
        exit();
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        *{
            box-sizing: border-box;
        }
        body{
            margin:0;
            padding:0;
            font-family:Arial, sans serif;
            background:linear-gradient(to right, #cccaca, #c00000);
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        h2{
            text-align:center;
            color: #960000;
            padding:20px;
            margin-bottom:10px;
        }
        .login{
            background-color: whitesmoke;
            border-radius:15px;
            padding:20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding:10px;
            border-radius:5px;
            margin-top:4px;
            outline:none;
        }
        input[type="text"]:focus,
        input[type="password"]:focus{
            border-color: #e72f2fff;
            box-shadow: 0 0 5px rgba(227, 47, 47, 0.5);
        }

        input[type="submit"]{
            width: 100%;
            padding:10px;
            border-radius:5px;
            border:none;
            background-color: #cf1919ff;
            color: whitesmoke;
        }
        input[type="submit"]:hover{
            background-color: rgb(151, 19, 19);
            
        }

    </style>
</head>
<body>
    <form action="" method="post">
        <div class="login">
            <h2>Login</h2>
            <label for="">Username</label>
            <input type="text" name="username" placeholder="Username" required> <br><br>
            <label for="">Username</label>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="submit" value="Login">
        </div>
    </form>
   <?php if($error): ?>
    <p class="error"><?= $error ?></p>
    <?php endif; ?>
</body>
</html>