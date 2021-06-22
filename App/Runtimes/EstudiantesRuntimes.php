<?php namespace App\Runtimes;


use  App\Mail\Mailer;
use App\Database\Repos\UsuariosRepo;
use App\Database\Repos\PersonasRepo;
use App\Database\Repos\EstudiantesRepo;


class EstudiantesRuntimes
{


    public static function registrarNuevoEstudiante($estudiante)
    {
        $birthday = $estudiante['date_birth'];
    
        if(UsuariosRepo::validateUserByEmail($estudiante['email']))
            return ['errors' =>['user' => 'El usuario ya existe']];
       
        $usuario = UsuariosRepo::crearUsuario($estudiante['email'], $estudiante['password'],bin2hex(openssl_random_pseudo_bytes(4, $cstrong)));
   
        $persona = PersonasRepo::crearPersona($estudiante['name'], $estudiante['last_name'], $estudiante['adress'], $estudiante['curp'],$estudiante['phone']);
          

        $estudiante = EstudiantesRepo::crearEstudiante($usuario['id'], $persona['id'], $birthday, bin2hex(openssl_random_pseudo_bytes(4, $cstrong)));
      

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
           'id_students' => $estudiante['id'],
           'name_students' => $persona['name']
       ]];
          
    }
}