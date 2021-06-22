<?php namespace App\Core;

use App\Endpoints\Auth;
use App\Core\Bridges\DataBridge;
use App\Database\Repos\Sesiones;
use App\Core\Bridges\FilesBridge;
use App\Core\Factory\FactoryUser;
use App\Core\Bridges\FiltersBridge;
use App\Core\Factory\FactoryServices;
use App\Core\Factory\FactoryEndpoints;
use Symfony\Component\HttpFoundation\FileBag;

class Client
{

    private $class;

    private $function;

    private $data;

    private FileBag $files;

    private $filters;

    private $services;

    private $serviceBridge;

    private DataBridge $dataBridge;

    private FiltersBridge $filtersBridge;

    private FilesBridge $filesBridge;

    private $endpointResponse;

    private $auth;

    public function __construct($class, $function, $data, FileBag $files, $filters, $services, $auth)
    {
        $this->class = $class;

        $this->function = $function;

        $this->data = $data;

        $this->files = $files;

        $this->filters = $filters;

        $this->services = $services;

        $this->auth = json_decode(base64_decode($auth), true);
    }   
    
    public function execute()
    {
        $this->makeServices();

        $this->makeData();

        $this->makeFilters();

        $this->makeFiles();

        $this->makeEndpoint();

        return $this->endpointResponse;
    }

    private function makeServices()
    {
        $services = new FactoryServices($this->services);

        $this->serviceBridge = $services->getFactory($this->class, 'test');
    }

    private function makeData()
    {
        $this->dataBridge = new DataBridge($this->data);
    }

    private function makeFilters()
    {
        $this->filtersBridge = new FiltersBridge($this->filters);
    }

    private function makeFiles()
    {
        $this->filesBridge = new FilesBridge($this->files);
    }

    private function makeEndpoint()
    {
        $factory = new FactoryEndpoints(
            $this->dataBridge,
            $this->filtersBridge,
            $this->filesBridge,
            $this->serviceBridge, 
            (!is_null($this->auth['head'])) ? Sesiones::traerSesionPorHashPrivado($this->auth['head']) : null
        );

        $this->endpointResponse = $factory->getFactory(
            $this->class,
            $this->function
        );
    }
}
