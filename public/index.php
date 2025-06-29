<?php

// Ambil URL path tanpa query string
$urlPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Simulasikan $_GET['url']
$_GET['url'] = $urlPath;

require_once __DIR__ . '/../vendor/autoload.php';

use NeyShiKu\CleanlyGo\Core\App;

$app = new App();
