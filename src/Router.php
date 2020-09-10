<?php

namespace JBP\Framework;

use JBP\Framework\Exceptions\HttpException;

class Router
{

    private $routes = [];

    public function add(string $method, string $pattern, $callback)
    {
        $method = strtolower($method);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = "/^$pattern$/";
        $this->routes[$method][$pattern] = $callback;
    }

    private function getCurrentUrl()
    {
        $url = $_SERVER['PATH_INFO'] ?? '/';

        if (empty($url)) {
            $url = $_SERVER['REQUEST_URI'] ?? '/';
        }

        if (strlen($url) > 1) {
            $url = rtrim($url, '/');
        }
        return $url;
    }

    public function run()
    {
        $url = $this->getCurrentUrl();
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if (empty($this->routes[$method])) {
            throw new HttpException('Page not found', 404);
        }

        foreach ($this->routes[$method] as $route => $action) {
            if (preg_match($route, $url, $params)) {
                return compact('action', 'params');
            }
        }

        throw new HttpException('Page not found', 404);
    }

}