<?php namespace App\Core\Factory;

use App\Core\Bridges\DataBridge;
use App\Core\Bridges\FilesBridge;
use App\Core\Bridges\FiltersBridge;
use App\Core\Bridges\ServiceBridge;
use App\Core\Interfaces\FactoryInterface;

class FactoryEndpoints implements FactoryInterface
{    

    private DataBridge $data;

    private FiltersBridge $filters;

    private FilesBridge $files;

    private ServiceBridge $service;

    private $auth;

    public function __construct(DataBridge $data, FiltersBridge $filters, FilesBridge $files, ServiceBridge $service, $auth)
    {
        $this->data = $data;

        $this->files = $files;

        $this->filters = $filters;

        $this->service = $service;

        $this->auth = $auth;
    }

    public function getFactory($class, $method)
    {
        $class = new $class(
            $this->data,
            $this->filters,
            $this->files,
            $this->service, 
            $this->auth
        );

        return $class->$method();
    }
}