<?php 

/**
 * @author DamianDev <damian27goa@gmail.com>
 * 
 * Este documento se encarga de hacer la carga de las librerias iniciales del proyecto
 * 
 * 1.- Se carga la libreria de manejo de plantillas PHP Plates
 * 2.- Se carga la libreria de manejo de errores Whoops
 * 
 */

session_start();

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
    die();
}

$configs = json_decode(@file_get_contents('../config.json'), true);

define("CONFIGS", $configs);
