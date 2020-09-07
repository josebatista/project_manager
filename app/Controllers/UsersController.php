<?php


namespace APP\Controllers;


use APP\Models\Users;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{

    public function show($container, Request $request)
    {
        $user = new Users($container);
        return $user->get($request->attributes->get(1));
    }

}