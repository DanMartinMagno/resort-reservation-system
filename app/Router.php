<?php

namespace App;

class Router {
    private $routes = [];
    private $middleware = [];

    public function get($path, $callback, $middleware = []) {
        $this->routes['GET'][$path] = $callback;
        $this->middleware['GET'][$path] = $middleware;
    }

    public function post($path, $callback, $middleware = []) {
        $this->routes['POST'][$path] = $callback;
        $this->middleware['POST'][$path] = $middleware;
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        
        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            $middleware = $this->middleware[$method][$uri] ?? [];

            // Run middleware
            foreach ($middleware as $m) {
                if (is_callable($m)) {
                    $m();
                }
            }

            // Execute the route callback
            if (is_array($callback)) {
                [$class, $method] = $callback;
                $controller = new $class();
                return $controller->$method();
            }
            
            if (is_callable($callback)) {
                return $callback();
            }
        }

        // 404 handler
        header("HTTP/1.0 404 Not Found");
        require VIEW_PATH . '/404.php';
    }
}
