<?php

namespace App\Entities\Order;

/**
 * Class OrderDirector
 * @package App\Entities\Order
 */
class OrderDirector
{
    /**
     * @var IOrderBuilder $orderBuilder
     */
    private $orderBuilder;

    /**
     * OrderDirector constructor.
     * @param IOrderBuilder $orderBuilder
     */
    private function __construct(IOrderBuilder $orderBuilder)
    {
        $this->orderBuilder = $orderBuilder;
    }

    /**
     * @param IOrderBuilder $orderBuilder
     * @return OrderDirector
     */
    public static function newInstance(IOrderBuilder $orderBuilder){
        return new self($orderBuilder);
    }

    /**
     * @param int $startRank
     * @param int $desiredRank
     * @param bool $duo
     * @return \App\Entities\Order\Order
     */
    public function createOrder($startRank, $desiredRank, $duo){
        $this->orderBuilder->buildOrderName();
        $this->orderBuilder->buildDuo($duo);
        $this->orderBuilder->buildStartRank($startRank);
        $this->orderBuilder->buildDesiredTank($desiredRank);
        $this->orderBuilder->buildPrice($startRank,$desiredRank,$duo);
        $this->orderBuilder->buildDescription($startRank,$desiredRank,$duo);
        $this->orderBuilder->buildOrderDate();
        $this->orderBuilder->buildInvoiceNumber($startRank,$desiredRank, $duo);
        return $this->orderBuilder->getOrder();
    }
}