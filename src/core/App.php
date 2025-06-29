<?php
namespace NeyShiKu\CleanlyGo\Core;

use NeyShiKu\CleanlyGo\Route\Routes;

class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    // Daftar route manual: url => [controller, method]
    protected $routes;

    public function __construct()
    {
        $this->routes = Routes::getRoutes();
        
        $url = $this->parseUrlString();

        if (isset($this->routes[$url])) {
            // Route custom ketemu
            $this->controller = $this->routes[$url][0];
            $this->method = $this->routes[$url][1];
        } else {
            $urlParts = $this->parseUrl();
            $controllerName = isset($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : $this->controller;
            $methodName = isset($urlParts[1]) ? $urlParts[1] : $this->method;

            $controllerPath = __DIR__ . "/../Controllers/" . $controllerName . ".php";
            $controllerClass = "NeyShiKu\\CleanlyGo\\Controllers\\" . $controllerName;

            if (file_exists($controllerPath) && method_exists($controllerClass, $methodName)) {
                $this->controller = $controllerName;
                $this->method = $methodName;
                unset($urlParts[0], $urlParts[1]);
                $this->params = $urlParts ? array_values($urlParts) : [];
            } else {
                // Arahkan ke halaman 404
                $this->controller = 'ErrorController';
                $this->method = 'notFound';
                $this->params = [];
            }
        }

        $controllerClass = "NeyShiKu\\CleanlyGo\\Controllers\\" . $this->controller;
        $this->controller = new $controllerClass;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrlString()
    {
        if (isset($_GET['url'])) {
            return rtrim(filter_var($_GET['url'], FILTER_SANITIZE_URL), '/');
        }
        return '';
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
