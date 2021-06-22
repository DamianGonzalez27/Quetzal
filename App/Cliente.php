<?php namespace App;

class Cliente
{
    public static function execute($urlBase, $endpoint, $method, $data, $llave)
    {
        $curl = curl_init();
        $fields = [
            '_method' => $method,
            '_data' => $data
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlBase.$endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                "content-type: multipart/form-data;",
                "llave: ".$llave
            ),
        ));

        $response = curl_exec($curl);
        
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
            return ['error' => $err];
        else 
            return $response;
        
    }
}