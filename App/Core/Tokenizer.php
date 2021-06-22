<?php namespace App\Core;

class Tokenizer
{
    public static function createFirstToken($id, $alias)
    {
        $hash = $id."|".$alias;
        $arrayHash = str_split($hash);
        $newHash = "/";

        for($i = 0; $i <count($arrayHash); $i++)
        {
            $newHash.=$arrayHash[$i]."-";
        }

        $newHash.="/";
        
        $hashPrivado = hash("sha256", $newHash);

        $hashPublico = [
            'head' => $hashPrivado,
            'body' => [
                'date' => date('Y-m-d H:i:s'),
                'dinamic' => bin2hex(openssl_random_pseudo_bytes(4, $cstrong))
            ]
        ];
        
        return [
            'hash_privado' => $hashPrivado,
            'hash_publico' => base64_encode(json_encode($hashPublico, true))
        ];
    }

    public static function createNewToken($hash)
    {
        $nuevoHashPublico = [
            'head' => $hash,
            'body' => [
                'date' => date('Y-m-d H:i:s'),
                'dinamic' => bin2hex(openssl_random_pseudo_bytes(4, $cstrong))
            ]
        ];

        return base64_encode(json_encode($nuevoHashPublico, true));
    }

    public static function validarToken($auth)
    {
        $tokenDecode = json_decode(base64_decode($auth), true);

        if(!isset($tokenDecode['head']) && !isset($tokenDecode['body']))
            return false;
        return true;
    }

}