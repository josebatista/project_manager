<?php


namespace JBP\Framework;

use JBP\Framework\Exceptions\HttpException;

class App
{

    private $container;
    private $route;
    private $middlewares = [
        'before' => [],
        'after' => []
    ];

    public function __construct($container, $route)
    {
        $this->container = $container;
        $this->route = $route;
    }

    public function addMiddleware($on, $callback)
    {
        $this->middlewares[$on][] = $callback;
    }

    public function run()
    {
        try {
            $result = $this->route->run();

            $params = [
                'container' => $this->container,
                'params' => $result['params']
            ];

            $response = new Response();

            foreach ($this->middlewares['before'] as $middleware) {
                $middleware($this->container);
            }

            $response($result['action'], $params);

            foreach ($this->middlewares['after'] as $middleware) {
                $middleware($this->container);
            }


        } catch (HttpException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
