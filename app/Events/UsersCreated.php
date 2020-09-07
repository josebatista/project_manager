<?php


namespace APP\Events;


class UsersCreated
{

    public function __invoke($e)
    {
        $event = $e->getName();
        $params = $e->getParams();

        echo sprintf('Disparando evento "%s", com parametros: %s<br><br>', $event, json_encode($params));
    }

}
