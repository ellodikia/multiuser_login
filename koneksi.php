<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "db_loginmultiuser";

$koneksi = new mysqli ($host, $user, $pass, $db ) {
    die ("Koneksi gagal: ".$koneksi->connect_error);
}