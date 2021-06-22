<?php namespace App\Core\Validators;

use Symfony\Component\HttpFoundation\File\UploadedFile;
class FilesValidator
{

    use \App\Core\Validators\MakeErrorTrait;

    public static function validateFiles($rules, $files)
    {
        $response = [];

        foreach($rules as $key => $value)
        {
            $file = $files->get($key);
            
            if($value['rule'] == 'required')
                if(is_null($file))
                    $responseRule = self::makeError($key, "The file: ".$key ." is required");
                else
                    $responseRule = self::aplyRules($value['formats'], $value['max-size'], $files->get($key));

            if($value['rule'] == 'optional')
                if(!is_null($file))
                    $responseRule = self::aplyRules($value['formats'], $value['max-size'], $files->get($key));
                else 
                    $responseRule = [];
            
            if(!is_null($responseRule) && !empty($responseRule))
                $response[$key] = $responseRule;
        }
        
        return $response;
    }

    private static function aplyRules($formats, $maxSize, UploadedFile $file)
    {
        $formatsRules = explode("|", $formats);

        $response = [];

        if(!in_array($file->getClientOriginalExtension(), $formatsRules))
            $response['format'] = self::makeError('extension', 'Invalid extension, expected: '.$formats.', original extension: '.$file->getClientOriginalExtension());

        if($file->getSize() > $maxSize)
            $response['size'] = self::makeError('size', 'Excesed size, expect: '. $maxSize.', original size: '.$file->getSize());

        return $response;
    }

}