<?php

use NeyShiKu\CleanlyGo\Controllers\ErrorController;

if (session_status() === PHP_SESSION_NONE) {
    require __DIR__ . '/../../../config/session.php';
}

if (!isset($_SESSION['id_user'])) {
    $ErrorController = new ErrorController();
    $ErrorController->notFound();
    exit;
}
?>