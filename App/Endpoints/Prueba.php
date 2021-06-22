<?php namespace App\Endpoints;

use App\Cliente;
use App\Database\Repos\Usuario;
use App\Core\Abstracts\AbstractEndpoints;
use App\Database\Repos\Micros;
use App\Database\Repos\Sesiones;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;

class Prueba extends AbstractEndpoints
{
    use \App\Core\Validators\MakeErrorTrait;

    public function prueba()
    {
        return new JsonResponse(
            [
                '_data' => [
                    'msg' => 'Hola Mundo',
                ],
            ],
            200
        );
    }
}
