<?php


namespace APP\Controllers;


use APP\Models\Users;

class UsersController
{

    public function show($container, $params)
    {
        $user = new Users($container);
        $data = $user->get($params[1]);

        return 'Olá meu nome é ' . $data['name'];
    }

}