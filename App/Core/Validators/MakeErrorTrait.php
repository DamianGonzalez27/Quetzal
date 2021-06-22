<?php namespace App\Core\Validators;

trait MakeErrorTrait
{
    public static function makeError($key, $message)
    {
        return [
            'name' => $key,
            'descripcion' => $message
        ];
    }

    public static function makeEndpointError($errorKey, $errors, $code)
    {
        return [
            'error' => [
                $errorKey => $errors
            ],
            'code' => $code
        ];
    }
}