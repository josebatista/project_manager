<?php


namespace JBP\Framework;


use Symfony\Component\HttpFoundation\Request;


abstract class CrudController
{
    abstract protected function getModel(): string;

    public function index($container, Request $request)
    {
        return $container[$this->getModel()]->all();
    }

    public function show($container, Request $request)
    {
        $condition = ['id' => $request->attributes->get(1)];
        return $container[$this->getModel()]->get($condition);
    }

    public function create($container, Request $request)
    {
        return $container[$this->getModel()]->create($request->request->all());
    }

    public function update($container, Request $request)
    {
        $condition = ['id' => $request->attributes->get(1)];
        return $container[$this->getModel()]->update($condition, $request->request->all());
    }

    public function delete($container, Request $request)
    {
        $condition = ['id' => $request->attributes->get(1)];
        return $container[$this->getModel()]->delete($condition);
    }
}
