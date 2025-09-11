<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_loginmultiuser";

$koneksi = neq mysqli ($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die ("Koneksi gagal: ". $koneksi->connect_error);
}