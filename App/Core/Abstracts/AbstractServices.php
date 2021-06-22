<?php namespace App\Core\Abstracts;

abstract class AbstractServices
{
    public function __construct($construct)
    {
        foreach($construct as $name => $value)
        {
            $this->$name = $value;
        }
    }

    public function getProperty($name)
    {
        return $this->$name;
    }
}