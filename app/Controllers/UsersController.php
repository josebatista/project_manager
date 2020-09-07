<?php


namespace APP\Controllers;


use APP\Models\Users;

class UsersController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function show($id)
    {
        $user = new Users($this->container);
        $data = $user->get($id);

        return 'Olá meu nome é ' . $data['name'];
    }

}