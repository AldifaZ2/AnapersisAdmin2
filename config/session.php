<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false, // Hanya jika HTTPS aktif
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_name("USER");
session_start();