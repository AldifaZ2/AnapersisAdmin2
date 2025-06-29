<?php
namespace NeyShiKu\CleanlyGo\Controllers;

use NeyShiKu\CleanlyGo\Core\Logger;
use NeyShiKu\CleanlyGo\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->view('homepage');

        $log = Logger::getLogger();
        $log->info('HomeController index');
    }
}
