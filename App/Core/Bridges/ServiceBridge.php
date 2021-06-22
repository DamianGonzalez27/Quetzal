<?php namespace App\Core\Bridges;

class ServiceBridge
{
    private $serviceCollection;

    public function __construct($serviceCollection)
    {
        $this->serviceCollection = $serviceCollection;
    }

    public function getService($serviceName)
    {
        return $this->serviceCollection[$serviceName];
    }
}