<?php

namespace App\PayPalService;

use PayPal\Rest\ApiContext;

trait PayPalTrait{
    /**
     * @return ApiContext
     */
    public function GetApiContext(){
        return $this['payPalApiContext']->GetApiContext();
    }
    /**
     * @param string $itemName
     * @param string $sku
     * @param float $price
     * @param string $description
     * @param string $invoiceNumber
     * @param string $successURL
     * @param string $failureURL
     */
    public function CreatePayment($itemName, $sku, $price, $description, $invoiceNumber,$successURL,$failureURL){
        $this['payPalWrapper']->CreatePayment($itemName, $sku, $price, $description, $invoiceNumber,$successURL,$failureURL);
    }
    /**
     * @param ApiContext $apiContext
     * @return string
     */
    public function GetApprovalUrl(ApiContext $apiContext){
        return $this['payPalWrapper']->GetApprovalUrl($apiContext);
    }

    /**
     * @param $payerId
     * @param $paymentID
     * @param ApiContext $apiContext
     * @return bool
     */
    public function Execute($payerId, $paymentID, ApiContext $apiContext){
        return $this['payPalWrapper']->Execute($payerId, $paymentID, $apiContext);
    }
}