<?php namespace App\Core\Interfaces;

interface FactoryInterface
{
    public function getFactory($class, $method);
}