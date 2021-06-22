<?php namespace App\Core\Abstracts;

use App\Database\Repos\Usuario;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{

    private $auth;

    private $path;

    public function __construct(Request $request)
    {
        $this->auth = json_decode(base64_decode($request->cookies->get('_auth')), true);

        $this->path = $request->query->get('path');
    }

    public function getProfile()
    {
        return Usuario::traerPerfilPorHash($this->auth['head']);
    }

    /**
     * Metodo para retornar views
     * 
     * Este metodo tiene la principal funcion de retornar un arreglo con la informacion de view y 
     * parametros a enviar al front
     * 
     * @param string $view Nombre de la vista a retornar
     * @param array $data Parametros e informacion de parseo en el front
     * 
     * @return array Regresa un array con la informacion principal de la respuesta
     */
    public function getView($view, $data = null)
    {
        return [
            'view' => $view,
            'data' => $data
        ];
    }

    public function getStorage($file, $mineType = null)
    {
        return [
            'storage' => true,
            'fileName' => $file,
            'mine-type' => $mineType
        ];
    }

    /**
     * Get the value of path
     */ 
    public function getPath()
    {
        return $this->path;
    }
}