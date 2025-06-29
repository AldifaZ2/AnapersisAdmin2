<?php
$host = "localhost"; //localhost
$user = "root"; //user
$pass = ''; //password
$dbname = "cleanlygo"; //nama database
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Error lebih jelas
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Ambil hasil sebagai array asosiatif
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // $message = "KONEKSI DATABASE BERHASIL";
    // echo "<script>console.log('" . $message . "');</script>";
} catch (\PDOException $e) {
    die("Gagal melakukan konkesi ke Server Database: " . $e->getMessage());
}
