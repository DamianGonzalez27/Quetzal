<?php

namespace App\Runtimes;

use App\Database\Repos\LoginRepo;


class LoginRuntimes
{
    public static function Login($usuario)
    {
        if (!LoginRepo::getUserByEmail($usuario['email']))
            return ['errors' => ['user' => 'El email es incorrecto']];

        if (!LoginRepo::getUserByPassword($usuario['password'], $usuario['email']))
            return ['errors' => ['user' => 'Contraseña incorrecta']];

        $logueo = LoginRepo::Login($usuario['email'], $usuario['password']);

        return ['data' => [
            'Email' => $logueo
        ]];
    }
}
