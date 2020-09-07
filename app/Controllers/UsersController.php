<?php


namespace APP\Controllers;


use APP\Models\Users;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{

    public function show($container, Request $request)
    {
        $user = new Users($container);

        //teste disparar eventos
        $user->create(['name' => 'teste']);

        return $user->get($request->attributes->get(1));
    }

}