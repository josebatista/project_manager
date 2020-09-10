<?php


namespace JBP\Framework;

use JBP\Framework\Exceptions\HttpException;
use JBP\Framework\Modules\ModuleRegistry;
use Pimple\Container;

class App
{
    private $composer;
    private $container;
    private $middlewares = [
        'before' => [],
        'after' => []
    ];

    public function __construct($composer, array $modules, Container $container = null)
    {
        $this->container = $container;
        $this->composer = $composer;

        if ($this->container === null) {
            $this->container = new Container();
        }

        $this->loadRegistry($modules);
    }

    public function addMiddleware($on, $callback)
    {
        $this->middlewares[$on][] = $callback;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function getRoutes()
    {
        if (!$this->container->offsetExists('router')) {
            $this->container['router'] = function () {
                return new Router();
            };
        }

        return $this->container['router'];
    }

    public function getResponder()
    {
        if (!$this->container->offsetExists('responder')) {
            $this->container['responder'] = function () {
                return new Response();
            };
        }

        return $this->container['responder'];
    }

    public function getHttpErrorHandler()
    {
        if (!$this->container->offsetExists('httpErrorHandler')) {
            $this->container['httpErrorHandler'] = function ($c) {
                header('Content-Type: application/json');

                return json_encode(['code' => $c['exception']->getCode(), 'error' => $c['exception']->getMessage()]);
            };
        }

        return $this->container['httpErrorHandler'];
    }

    public function run()
    {
        try {
            $result = $this->getRoutes()->run();

            $params = [
                'container' => $this->container,
                'params' => $result['params']
            ];

            $response = $this->getResponder();

            foreach ($this->middlewares['before'] as $middleware) {
                $middleware($this->container);
            }

            $response($result['action'], $params);

            foreach ($this->middlewares['after'] as $middleware) {
                $middleware($this->container);
            }


        } catch (HttpException $e) {
            $this->container['exception'] = $e;
            echo $this->getHttpErrorHandler();
        }
    }

    private function loadRegistry($modules)
    {
        $registry = new ModuleRegistry();

        $registry->setApp($this);
        $registry->setComposer($this->composer);

        foreach ($modules as $file => $module) {
            require $file;
            $registry->add(new $module);
        }

        $registry->run();
    }
}
