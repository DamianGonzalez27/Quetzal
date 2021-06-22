<?php namespace App\Core\Factory;

use App\Core\Interfaces\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class FactoryModelViews implements FactoryInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getFactory($class, $method)
    {
        $controller = new $class($this->request);

        return $controller->$method();
    }
}