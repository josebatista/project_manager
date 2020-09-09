<?php


namespace JBP\Framework;

use JBP\Framework\Exceptions\HttpException;
use Pimple\Container;

class App
{

    private $container;
    private $middlewares = [
        'before' => [],
        'after' => []
    ];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function addMiddleware($on, $callback)
    {
        $this->middlewares[$on][] = $callback;
    }

    public function getRouter()
    {
        if (!$this->container->offsetExists('router')) {
            $this->container['router'] = function () {
                return new Router();
            };
        }

        return $this->container['router'];
    }

    public function run()
    {
        try {
            $result = $this->getRouter()->run();

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
