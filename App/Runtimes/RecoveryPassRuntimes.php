<?php namespace App\Runtimes;
use App\Mail\Mailer;
use App\Database\Repos\EmailRepo;

/**
     * Funcion que sirve para recuperar password de un usuario
     * @param array $usuario
     * @return array 
*/

final class RecoveryPassRuntimes
{
     public static function RecoveryPassUsers($usuario)
     {
         $email = EmailRepo::getUserEmail($usuario);
        if(!$email)
        return ['errors'=> ['user'=> 'El usuario no existe']];

        $token = bin2hex(openssl_random_pseudo_bytes(4, $cstrong));
        $tokenSave= EmailRepo::saveToken($token,$email);

        $templates = new \League\Plates\Engine('../views/mails');
        $templates->loadExtension(new \League\Plates\Extension\URI($_SERVER['SERVER_NAME']));

        $test = $templates->render('example', [
            'token' => $token,
            'email' => $email['email']
        ]);

        $mail = new Mailer();
        $mail->setFrom('info@hamiltonandlovelace.com');
        $mail->addAddress($email['email']);
        $mail->isHtml();
        $mail->addSubject('Recupera tu cuenta');
        $mail->addTemplate($test);
        $mail->send();
        
        return [
            'data' => [
                'token' => $tokenSave,
                'correo' => $email['email']
                
            ]
        ];
     } 
}