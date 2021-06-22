<?php namespace App\Core\Factory;

use App\Core\Interfaces\FactoryInterface;
use App\Core\Bridges\ServiceBridge;

class FactoryServices implements FactoryInterface
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function getFactory($class, $method)
    {
        $serviceCollection = [];
        foreach($this->services as $service => $value)
        {
            $serviceClass = $value['class'];
            $construct = $value['construct'];
            $serviceCollection[$service] = new $serviceClass($construct);
        }   
        return new ServiceBridge($serviceCollection);
    }
}