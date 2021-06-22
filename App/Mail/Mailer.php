<?php namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        //$this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
        $this->mailer->isSMTP();                                            // Send using SMTP
        $this->mailer->Host       = CONFIGS['smtp']['host'];                // Set the SMTP server to send through
        $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mailer->Username   = CONFIGS['smtp']['user'];                // SMTP username
        $this->mailer->Password   = CONFIGS['smtp']['pass'];                // SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mailer->Port       = 587;
    }


    public function setFrom($from)
    {
        $this->mailer->setFrom($from, 'Proyecto educación');
    }

    public function addAddress($address)
    {
        $this->mailer->addAddress($address);
    }

    public function isHtml()
    {
        $this->mailer->isHTML(true);
    }

    public function addSubject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function addTemplate($template)
    {
        $this->mailer->Body = $template;
    }

    public function send()
    {
        try
        {
            $this->mailer->send();
            return 'Success';
        }
        catch(Exception $e)
        {
            return "Error";
        }
        
    }

}