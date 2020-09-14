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
        $condition = ['id' => $request->attributes->get(1)];
        return $user->get($condition);
    }

    public function create($container, Request $request)
    {
        $user = new Users($container);
        return $user->create($request->request->all());
    }

    public function update($container, Request $request)
    {
        $user = new Users($container);
        $condition = ['id' => $request->attributes->get(1)];
        return $user->update($condition, $request->request->all());
    }

    public function delete($container, Request $request)
    {
        $user = new Users($container);
        $condition = ['id' => $request->attributes->get(1)];
        return $user->delete($condition);
    }
}
