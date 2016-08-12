<?php

namespace App\Entities\Order;

/**
 * Class InvoiceNumberGenerator
 * @package App\Entities\Order
 */
class InvoiceNumberGenerator {
    /**
     * @param int $startRank CurrentRank if Per Win Boost
     * @param int $desiredRank Number of wins if Per Win Boost
     * @return string Return Invoice Number
     */
    static public function Get($startRank, $desiredRank, $duo) {
        return date("YHis") . $startRank . $desiredRank.$duo;
    }
}