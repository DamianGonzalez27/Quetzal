<?php namespace App\Runtimes;
use App\Mail\Mailer;
use App\Database\Repos\EmpresasRepo;
use App\Database\Repos\UsuariosRepo;


class EmpresasRuntimes
{
    /**
     * Funcion que crea una empresa
     * @param array $empresa
     * @return array 
     */
    public static function registrarEmpresa($empresa)
    {
        if(UsuariosRepo::validateUserByEmail($empresa['email']))
        return ['errors'=> ['user'=> 'El usuario ya existe']];

        $token = bin2hex(openssl_random_pseudo_bytes(4, $cstrong));
        $usuario = UsuariosRepo::crearUsuario($empresa['email'], $empresa['password'], $token);
        $empresa = EmpresasRepo::crearEmpresa($empresa['nombre'], $empresa['rfc'],$empresa['direccion'], $empresa['telefono'], $usuario['id']);

        $templates = new \League\Plates\Engine('../views/mails');
        $templates->loadExtension(new \League\Plates\Extension\URI($_SERVER['SERVER_NAME']));

        $test = $templates->render('example', [
            'token' => $usuario['token'],
            'email' => $usuario['email']
        ]);

        $mail = new Mailer();
        $mail->setFrom('info@hamiltonandlovelace.com');
        $mail->addAddress($empresa['email']);
        $mail->isHtml();
        $mail->addSubject('Bienvenido');
        $mail->addTemplate($test);
        $mail->send();

        return ['data' => [
            'id_usuario' => $usuario['id'],
            'id_empresa' => $empresa['id'],
            'nombre_empresa' => $empresa['nombre']
        ]];
    }

}

