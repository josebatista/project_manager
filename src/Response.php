<?php


namespace JBP\Framework;

use Symfony\Component\HttpFoundation\Request;

class Response
{

    public function __invoke($action, $params)
    {

        parse_str(file_get_contents('php://input'), $_POST);
        $request = new Request(
            $_GET,
            $_POST,
            $params['params'],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        if (is_string($action)) {
            $action = explode('::', $action);
            $action[0] = new $action[0];
        }

        $params['params'] = $request;

        echo call_user_func_array($action, $params);
    }

}