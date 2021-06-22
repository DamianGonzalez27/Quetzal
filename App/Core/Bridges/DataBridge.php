<?php namespace App\Core\Bridges;

class DataBridge
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getParam($paramName)
    {
        return $this->data[$paramName];
    }
}