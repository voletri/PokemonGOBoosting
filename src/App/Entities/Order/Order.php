<?php

namespace App\Entities\Order;
/**
 * Class Order
 * @package App\Entities\Order
 * @property int $price
 * @property string $orderName
 * @property bool $duo
 * @property string $description
 * @property string $invoiceNumber
 * @property string $orderDate
 * @property int $startRank
 * @property int $desiredRank Number of wins for Per Win Boost Order
 */
class Order {
    /**
     * @var int $price
     */
    protected $price;
    /**
     * @var string $orderName
     */
    protected $orderName;
    /**
     * @var bool $duo
     */
    protected $duo;
    /**
     * @var string $description
     */
    protected $description;
    /**
     * @var string $invoiceNumber
     */
    protected $invoiceNumber;
    /**
     * @var string $orderDate
     */
    protected $orderDate;
    /**
     * @var int $startRank Start Rank for Rank Boost and Current Rank for Per Win Boost
     */
    protected $startRank;
    /**
     * @var int $desiredRank Desired Rank for Rank Boost and Number of wins for Per Win Boost
     */
    protected $desiredRank;

    /**
     * Order constructor.
     */
    public function __construct() {
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }
}