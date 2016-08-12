<?php
namespace App\MailingService;

use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Mime_Message;

/**
 * Class Mailer
 * @package App\MailingService
 * @property Swift_Mailer $mailer
 * @property Swift_Mime_Message $message
 */
class Mailer{
    private $mailer;
    private $log;
    private $message;
    const logDir = __DIR__ . '/../../../logs';
    const logFile = '/MailingService.log';

    public function __construct($options) {
        $username = (array_key_exists('username',$options)?$options['username']:null);
        $password =(array_key_exists('password',$options)?$options['password']:null);
        $host = (array_key_exists('host',$options)?$options['host']:null);
        $port = (array_key_exists('port',$options)?$options['port']:null);
        $this->log =(array_key_exists('log',$options)?$options['log']:true);
       $transport = Swift_SmtpTransport::newInstance()
           ->setUsername($username)
           ->setPassword($password)
           ->setHost($host)
           ->setPort($port);
        $this->mailer = Swift_Mailer::newInstance($transport);
    }
    public function send(Swift_Mime_Message $message){
        $this->message = $message;
        try{
            $this->mailer->send($message);
            if($this->log)
            self::log(true);

            return true;
        }catch(\Exception $exp){
            if($this->log)
            self::log(false,$exp);

            return false;
        }
    }
    private function log($successful, \Exception $exp=null){
        $title = $this->message->getSubject();
        $toArray = $this->message->getTo();
        $fromArray = $this->message->getFrom();
        $log = '[' . date("Y/m/d H:i:s") . '] Message: '.$title.' To: ';
        foreach($toArray as $to){
            $log.=" {$to}";
        }
        $log.=" From: ";
        foreach ($fromArray as $from){
            $log.=" {$from}";
        }
        if($successful){
            $log.=" was sent";
        }else{
            $log.=" was not sent";
        }
        if($exp!==null){
            $log.=" Code: {$exp->getCode()} {$exp->getMessage()} File: {$exp->getFile()} Line: {$exp->getLine()} Trace: {$exp->getTraceAsString()}";
        }
        $log.=PHP_EOL;
        if (file_exists(self::logDir) != true) {
            mkdir(self::logDir);
        }
        file_put_contents(self::logDir . self::logFile, $log, FILE_APPEND);
    }
}