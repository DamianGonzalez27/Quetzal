<?php namespace App\Core\Validators;

use App\Core\Tokenizer;
use App\Database\Repos\PermisosRol;
use App\Database\Repos\Sesiones;
use Symfony\Component\HttpFoundation\Request;

class AuthValidator
{
    public static function validateAuth(Request $request)
    {

        $auth = $request->cookies->get('_auth');

        if(!isset($auth) || $auth === '' || $auth === "")
            return false;

        if(!Tokenizer::validarToken($auth))
            return false;

        if(!Sesiones::traerSesionPorHash($auth))
            return false;

        return true;
    }

    public static function validatePublicStrict(Request $request)
    {
        $auth = $request->cookies->get('_auth');

        if(isset($auth) || $auth != '' || $auth != "")
            return true;

        return false;
    }

    public static function validatePermission(Request $request, $permisos)
    {
        if($permisos == 'no')
            return true;

        $usuarioId = Sesiones::traerSesionPorHash($request->cookies->get('_auth'))['usuario_id'];

        $permisosUsuario = PermisosRol::traerPermisosPorIdUsuario($usuarioId);

        foreach($permisosUsuario as $permiso)
        {
            if($permiso['llave'] == $permisos)
                return true;
        }

        return false;
    }
}