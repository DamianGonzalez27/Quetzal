<?php namespace App\Core\Abstracts;

use App\Core\Bridges\DataBridge;
use App\Core\Bridges\FilesBridge;
use App\Core\Bridges\FiltersBridge;
use App\Core\Bridges\ServiceBridge;


abstract class AbstractEndpoints
{
    /**
     * Puente de datos de entrada
     * 
     * Obtenemos la informacion del campo _data
     * 
     * @var DataBridge
     */
    private DataBridge $dataBridge;

    /**
     * Puente de filtros de entrada
     * 
     * Obtiene la informacion del campo _filters
     * 
     * @var FiltersBridge
     */
    private FiltersBridge $filtersBridge;

    /**
     * Puente de archivos
     * 
     * Obtiene los ficheros de entrada
     * 
     * @var FilesBridge
     */
    private FilesBridge $filesBridge;

    /**
     * Puente de servicios
     * 
     * Obtiene los servicios configurados
     * 
     * @var ServiceBridge
     */
    private ServiceBridge $serviceBridge;

    private $auth;

    public function __construct(DataBridge $dataBridge, FiltersBridge $filtersBridge, FilesBridge $filesBridge, ServiceBridge $serviceBridge, $auth)
    {
        $this->dataBridge = $dataBridge;

        $this->filtersBridge = $filtersBridge;

        $this->filesBridge = $filesBridge;

        $this->serviceBridge = $serviceBridge;

        $this->auth = $auth;
    }

    /**
     * Obtiene todos los datos del campo _data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->dataBridge->getData();
    }

    /**
     * Obtiene un valor determinado por nombre del campo _data
     * 
     * @return string
     */
    public function getParam($paramName)
    {
        return $this->dataBridge->getParam($paramName);
    }

    /**
     * Obtiene los datos del campo _filters
     * 
     * @return array
     */
    public function getFilters()
    {
        return $this->filtersBridge->getFilters();
    }

    /**
     * Obtiene un valor determinado por nombre del campo _filters
     * 
     * @return array
     */
    public function getFilter($filterName)
    {
        return $this->getFilter($filterName);
    }

    /**
     * Obtiene una coleccion de ficheros de entrada
     * 
     * @return Collection
     */
    public function getFiles()
    {
        return $this->filesBridge->getFiles();
    }

    /**
     * Obtiene un fichero especifico determinado por nombre
     * 
     * @return File
     */
    public function getFile($fileName)
    {
        return $this->filesBridge->getFile($fileName);
    }

    /**
     * Obtiene una clase de servicio configurado
     * 
     * @return Class
     */
    public function getService($serviceName)
    {
        return $this->serviceBridge->getService($serviceName);
    }

    public function getUserId()
    {
        return $this->auth['usuario_id'];
    }

    public function getSesionId()
    {
        return $this->auth['id'];
    }

    public function getHashPrivado()
    {
        return $this->auth['hash_privado'];
    }
}