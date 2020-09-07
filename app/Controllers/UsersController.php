<?php


namespace APP\Controllers;


use APP\Models\Users;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{

    public function show($container, Request $request)
    {

        $user = new Users($container);
        $data = $user->get($request->attributes->get(1));

        return 'Olá meu nome é ' . $data['name'];
    }

}