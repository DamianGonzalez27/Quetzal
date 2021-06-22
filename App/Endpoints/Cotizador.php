<?php namespace App\Endpoints;

use App\Database\Repos\Usuario;
use App\Core\Abstracts\AbstractEndpoints;
use App\Database\Repos\Sesiones;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;

class Cotizador extends AbstractEndpoints
{
    use \App\Core\Validators\MakeErrorTrait;

    public function cotizar()
    {
        return new JsonResponse([
            '_data' => [
                'mensaje' => 'Todo ok'
            ]
        ]);
    }

}