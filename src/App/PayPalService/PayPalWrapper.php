<?php
namespace App\PayPalService;

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Rest\ApiContext;

class PayPalWrapper
{
    private $payment;
    private $currency;
    private $paymentMethod;

    public function __construct(array $options)
    {
        $this->currency = (array_key_exists('currency',$options)?$options['currency']:'EUR');
        $this->paymentMethod =(array_key_exists('paymentMethod',$options)?$options['paymentMethod']:'paypal');
        $this->payment = new Payment();
    }


    /**
     * @param string $itemName
     * @param string $sku
     * @param float $price
     * @param string $description
     * @param string $invoiceNumber
     */
    public function CreatePayment($itemName, $sku, $price, $description, $invoiceNumber,$successURL,$failureURL)
    {
        $payer = new Payer();
        $payer->setPaymentMethod($this->paymentMethod);

        $item = new Item();
        $item->setName($itemName)
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setSku($sku)
            ->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems(array(
            $item
        ));

        $details = new Details();
        $details->setSubtotal($price);

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($price)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($description)
            ->setInvoiceNumber($invoiceNumber);

        $redirectURL = new RedirectUrls();
        $redirectURL->setReturnUrl($successURL.'?success=1')
            ->setCancelUrl($failureURL . '?success=0');

        $this->payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectURL)
            ->setTransactions(array(
                $transaction
            ));
    }

    public function GetApprovalUrl(ApiContext $apiContext)
    {
        $this->payment->create($apiContext);
        return $this->payment->getApprovalLink();
    }

    public function Execute($payerId, $paymentID, ApiContext $apiContext)
    {
        $payment = Payment::get($paymentID, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        try {
            $payment->execute($execution, $apiContext);
            return true;
        } catch (\Exception $exp) {
            return false;
        }
    }
}
