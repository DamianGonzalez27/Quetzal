<?php namespace App\Runtimes;

use App\Mail\Mailer;
use App\Database\Repos\TestRepo;

final class TestRunTime
{

    private $templates;






    

    public function __construct()
    {
        $this->templates = new \League\Plates\Engine('../views/mails');
        $this->templates->loadExtension(new \League\Plates\Extension\URI($_SERVER['SERVER_NAME']));
    }

    public function registerTest($request)
    {
        $token = bin2hex(openssl_random_pseudo_bytes(4, $cstrong));

        $register = TestRepo::createTest([
            'name' => $request->getParam('name'),
            'last_name' => $request->getParam('last_name'),
            'email' => $request->getParam('email'), 
            'token' => $token
        ]);

        $test = $this->templates->render('example', [
            'data' => $register
        ]);

        $mail = new Mailer();
        $mail->setFrom('info@hamiltonandlovelace.com');
        $mail->addAddress($request->getParam('email'));
        $mail->isHtml();
        $mail->addSubject('Esto es un correo de pruebas');
        $mail->addTemplate($test);
        $mail->send();

        if($mail)
            return true;
        else
            return false;
    }

    public function testmethod()
    {
        // dd($this->templates);
    }
}