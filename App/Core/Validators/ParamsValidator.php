<?php namespace App\Core\Validators;

use App\CustomRulesValidator;
use App\Database\Repo;
class ParamsValidator extends CustomRulesValidator
{

    use \App\Core\Validators\MakeErrorTrait;

    public static function validateParams($params, $data)
    {
        $response = [];

        foreach($params as $key => $value)
        {
            $rules = explode("|", $value);

            $responseRule = self::aplyRules($rules, $data, $key);
            
            if($responseRule)
                $response[$key] = $responseRule;
        }
        
        return $response;
    }

    private static function aplyRules($rules, $data, $paramName)
    {
        foreach($rules as $rule => $value)
        {
            $realRule = explode(":", $value);

            switch($realRule[0])
            {
                case 'optional': 
                    if(!isset($data[$paramName]))
                        return false;
                    if($data[$paramName] == '')
                        return false;
                break;

                case 'required': 
                    if(!isset($data[$paramName]))
                        return self::makeError($paramName, "El parámetro ".$paramName." es requerido");
                break;
                
                case 'email': 
                    if(!preg_match('/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i', $data[$paramName]))
                        return self::makeError($paramName, "Formato de correo incorrecto");
                break;

                case 'max': 
                    if(strlen($data[$paramName]) > $realRule[1])
                        return self::makeError($paramName, "El máximo de caracteres es: ".$realRule[1]);
                break;

                case 'min': 
                    if(strlen($data[$paramName]) < $realRule[1])
                        return self::makeError($paramName, "El mínimo de caracteres es: ".$realRule[1]);
                break;

                case 'index': 
                    $index = explode(",", $realRule[1]);
                    if(!in_array($realRule[0], $index))
                        return self::makeError($paramName, "Apuntador incorrecto: ".$realRule[1]." esperado: ".$realRule[1]);
                break;

                case 'unique':
                    $value = explode(",", $realRule[1]);
                    if(Repo::validateUniquerule($value[0], $value[1], $data[$paramName]))
                        return self::makeError($paramName, "El usuario ya existe");
                break;

                case 'captcha': 
                    $captcha = new \Anhskohbo\NoCaptcha\NoCaptcha('', '');
                    if(!$captcha->verifyResponse($data[$paramName]))
                        return self::makeError($paramName, "Es necesario validar el captcha");
                break;
                default: 
                    return self::aplyCustomRules($realRule[0], $realRule[1], $data[$paramName], $paramName);
                break;
            }
        }
    }
}