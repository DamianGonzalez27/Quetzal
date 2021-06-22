<?php namespace App\Runtimes;


use  App\Mail\Mailer;
use App\Database\Repos\UsuariosRepo;
use App\Database\Repos\PersonasRepo;
use App\Database\Repos\InstructoresRepo;


class InstructoresRuntimes
{


    public static function registrarNuevoInstructor($instructor)
    {
       
    
        if(InstructoresRepo::validateInstructorByEmail($instructor['email']))
            return ['errors' =>['user' => 'El instructor ya existe']];
       
        $usuario = UsuariosRepo::crearUsuario($instructor['email'], $instructor['password'],bin2hex(openssl_random_pseudo_bytes(4, $cstrong)));
   
        $persona = PersonasRepo::crearPersona($instructor['name'], $instructor['last_name'], $instructor['adress'], $instructor['curp'],$instructor['phone']);
          

        $instructor = InstructoresRepo::crearInstructor($usuario['id'], $persona['id'], bin2hex(openssl_random_pseudo_bytes(4, $cstrong)));
      

        // $templates = new \League\Plates\Engine('../views/mails');
        // $templates->loadExtension(new \League\Plates\Extension\URI($_SERVER['SERVER_NAME']));

        // $test = $templates->render('example',[
        //     'token' => $usuario['token'],
        //     'email' => $estudiante['email']
        // ]);

        // $mail = new Mailer();
        // $mail->setFrom('info@hamiltonandlovelace.com');
        // $mail->addAddress($estudiante['email']);
        // $mail->isHtml();
        // $mail->addSubject('Bienvenido');
        // $mail->addTemplate($test);
        // $mail->send();
       
        return ['data' =>[
           'id_users' => $usuario['id'],
           'id_instructor' => $instructor['id'],
           'name_instructor' => $persona['name'],
           'last_name_instructor' => $persona['last_name']
       ]];
          
    }
}