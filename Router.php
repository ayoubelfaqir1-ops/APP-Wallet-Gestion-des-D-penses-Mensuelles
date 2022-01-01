<?php

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        
        $callback = $this->routes[$method][$path] ?? null;
        
        if (!$callback) {
            header("HTTP/1.0 404 Not Found");
            echo "404";
            return;
        }
        
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }
        
        call_user_func($callback);
    }
}