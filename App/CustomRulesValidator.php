<?php namespace App;
class CustomRulesValidator
{
    use \App\Core\Validators\MakeErrorTrait;

    public static function aplyCustomRules($nameRule, $valuRule, $paramValue, $paramName)
    {
        switch($nameRule)
        {
            case 'rule':
                // ... Aplica aqui tus propias reglas
            break;
        }
    }
}