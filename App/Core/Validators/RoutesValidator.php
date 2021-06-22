<?php namespace App\Core\Validators;

use Symfony\Component\HttpFoundation\Request;

class RoutesValidator
{

    public static function validatePublicStrict(Request $request, $routes)
    {
        $auth = $request->cookies->get('_auth');

        if($routes == 'public-strict' && !is_null($auth) && !empty($auth) && $auth != '' && $auth !="")
            return false;

        return true;
    }

    public static function validateIssetPath($path)
    {
        if($path == '' || $path == "")
            return false;

        return true;
    }

    public static function validatePublicRoute($access)
    {
        if($access == 'public')
            return true;

        if($access == 'public-strict')
            return true;

        return false;
    }

    public static function validateSubRoutes($routes)
    {
        if(!isset($routes['sub-routes']))
            return false;

        return true;
    }

    public static function validateRoute($routes, $route)
    {
        if(!isset($routes[$route]))
            return false;

        return true;
    }

    public static function validateIssetSubroutePath($arrayPath)
    {
        if(count($arrayPath) == 3)
            return true;
        return false;
    }

    public static function validateMaxArrayPath($arrayPath)
    {
        if(count($arrayPath) > 3)
            return false;

        return true;
    }

    public static function validateEnpoint($arrayPath)
    {
        if(count($arrayPath) > 2)
            return false;
            
        return true;
    }
}