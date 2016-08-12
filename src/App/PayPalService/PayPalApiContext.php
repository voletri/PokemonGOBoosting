<?php
namespace App\PayPalService;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalApiContext
{
    private $apiContext;
    const logDir =__DIR__.'/../../../logs';
    const logFile = '/PayPal.log';
    const logLevel = 'FINE';

    /**
     * PayPalApiContext constructor.
     * @param array $options
     */
    public function __construct($options)
    {
        $live = (array_key_exists('live',$options)?$options['live']:null);
        $clientID = (array_key_exists('clientID',$options)?$options['clientID']:null);
        $secret = (array_key_exists('secret',$options)?$options['secret']:null);
        $connectionTimeOut = (array_key_exists('connectionTimeOut',$options)?$options['connectionTimeOut']:30);
        $log = (array_key_exists('log',$options)?$options['log']:true);

        if(file_exists(self::logDir)!=true){
            mkdir(self::logDir);
        }
        if($live){
            $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $clientID,
                $secret
            ));
            $this->apiContext->setConfig(array(
                'mode'=>'live',
                'http.ConnectionTimeOut' => $connectionTimeOut,
                'log.LogEnabled' => $log,
                'log.FileName' =>self::logDir.self::logFile,
                'log.LogLevel' => self::logLevel
            ));
        }else{
            $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $clientID,
                $secret
            ));
            $this->apiContext->setConfig(array(
                'mode'=>'sandbox',
                'http.ConnectionTimeOut' => $connectionTimeOut,
                'log.LogEnabled' => $log,
                'log.FileName' =>self::logDir.self::logFile,
                'log.LogLevel' => self::logLevel
            ));
        }
    }

    public function GetApiContext()
    {
        return $this->apiContext;
    }
}