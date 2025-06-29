<?php

use NeyShiKu\CleanlyGo\Controllers\ErrorController;

if (session_status() === PHP_SESSION_NONE) {
    require __DIR__ . '/../../../config/session.php';
}

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    $ErrorController = new ErrorController();
    $ErrorController->notFound();
    exit;
}

// Tambahkan ini untuk mendefinisikan variable yang dibutuhkan
$userId = $_SESSION['id_user'];
$role = $_SESSION['role'];

// Ambil nama dari session atau set default
$nama = $_SESSION['nama'] ?? $_SESSION['name'] ?? $_SESSION['username'] ?? 'Administrator';
$email = $_SESSION['email'] ?? 'admin@cleanlygo.com';
?>