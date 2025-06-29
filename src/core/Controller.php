<?php
namespace NeyShiKu\CleanlyGo\Core;

class Controller
{
    protected function view(string $viewName, array $data = [])
    {
        $viewFile = __DIR__ . "/../views/{$viewName}.php";

        if (file_exists($viewFile)) {
            extract($data); // variabel dari array jadi variabel biasa
            require $viewFile;
        } else {
            echo "View '{$viewName}' tidak ditemukan.";
        }
    }
}
