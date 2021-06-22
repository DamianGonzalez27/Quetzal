<?php namespace App\Core\Validators;

use Symfony\Component\HttpFoundation\FileBag;
use App\Core\Validators\ParamsValidator;

class FiltersValidator
{
    public static function validateFilters($rules, $filters)
    {
        $response = [];
        
        if(is_null($filters))
            return $response;

        if(empty($filters))
            return $response;

        foreach($filters as $filter => $valueFilter)
        {
            foreach($rules as $rule => $valueRule)
            {
                if($rule == $filter)    
                    $result = ParamsValidator::validateParams($valueRule, $valueFilter);
                else
                    $result = [];
                
                if(!empty($result))
                    $response[$rule] = $result;
            }
        }

        return $response;
    }
}