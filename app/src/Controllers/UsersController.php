<?php


namespace App\Controllers;


use App\Models\Users;
use Symfony\Component\HttpFoundation\Request;


class UsersController
{

    public function index($container, Request $request)
    {
        $users = new Users($container);
        return $users->all();
    }

    public function show($container, Request $request)
    {
        $user = new Users($container);
        return $user->get($request->attributes->get(1));
    }

    public function create($container, Request $request)
    {
        $user = new Users($container);
        return $user->create($request->request->all());
    }

    public function update($container, Request $request)
    {
        return 'update';
    }

    public function delete($container, Request $request)
    {
        return 'delete';
    }
}
