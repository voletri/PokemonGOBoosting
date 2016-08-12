<?php

namespace App\Entities\Order;

/**
 * Interface IOrderBuilder
 * @package App\Entities\Order
 */
interface IOrderBuilder {

    public function buildOrderName();

    /**
     * @param bool $duo
     */
    public function buildDuo($duo);

    /**
     * @param int $startRank
     */
    public function buildStartRank($startRank);

    /**
     * @param int $desiredRank
     */
    public function buildDesiredTank($desiredRank);

    /**
     * @param int $startRank
     * @param int $desiredRank
     * @param bool $duo
     */
    public function buildPrice($startRank, $desiredRank, $duo);

    /**
     * @param int $startRank
     * @param int $desiredRank
     * @param  bool $duo
     */
    public function buildDescription($startRank, $desiredRank, $duo);

    public function buildOrderDate();

    /**
     * @param int $startRank
     * @param int $desiredRank
     * @param bool $duo
     */
    public function buildInvoiceNumber($startRank, $desiredRank, $duo);

    /**
     * @return Order
     */
    public function getOrder();
}