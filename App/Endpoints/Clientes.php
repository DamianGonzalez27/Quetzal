<?php namespace App\Endpoints;

use App\Cliente;
use App\Database\Repos\Usuario;
use App\Core\Abstracts\AbstractEndpoints;
use App\Database\Repos\Micros;
use App\Database\Repos\Sesiones;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;

class Clientes extends AbstractEndpoints
{
    use \App\Core\Validators\MakeErrorTrait;

    public function buscarCorreo()
    {
        $micro = Micros::traerPorNombre('clientes');
        $llave = Micros::traerLlave($micro['id']);
        
        $cliente = Cliente::execute(
            $micro['url_base'],
            'clientes',
            'buscar-por-correo',
            json_encode($this->getData(), true),
            $llave['hash_publico']
        );
        
        if(isset($cliente['error']))
            return new JsonResponse([
                '_errors' => [
                    'mensaje' => 'Ocurrio un error',
                    'detalles' => $cliente['error']
                ]
            ], 200);
        
        return new JsonResponse(
            json_decode($cliente, true),
         200);
    }

    public function test()
    {
        // Crear logica de negocio
        return new JsonResponse([
            '_data' => [
                'hola' => 'mundo'
            ]
        ], 200);
    }
}