<?php
namespace App\MailingService;

use Swift_Mime_Message;

trait MailerTrait{


    /**
     * @param Swift_Mime_Message $message
     * @return bool
     */
    public function sendMail(Swift_Mime_Message $message){
        return $this['mailer']->send($message);
    }
}