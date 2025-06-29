<?php
namespace NeyShiKu\CleanlyGo\Controllers;

use NeyShiKu\CleanlyGo\Core\Controller;

class ErrorController extends Controller {
    public function notFound() {
        http_response_code(404);
        
        $this->view('error/404');
    }
}