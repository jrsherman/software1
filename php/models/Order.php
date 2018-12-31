<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/8/18
 * Time: 7:22 PM
 */

class Order
{
    /**
     * @var double
     */
    public $pickupLongitude;

    /**
     * @var double
     */
    public $pickupLatitude;

    /**
     * @var double
     */
    public $destinationLongitude;

    /**
     * @var double
     */
    public $destinationLatitude;

    /**
     * @var double
     */
    public $closestRobotaxiLongitude;

    /**
     * @var double
     */
    public $closestRobotaxiLatitude;

    /**
     * @var int
     */
    public $estimatedTimeOfArrival;

    /**
     * @var int
     */
    public $orderId;
    
    
    public $customerId;

    /**
     * Order constructor.
     * @param float $pickupLongitude
     * @param float $pickupLatitude
     * @param float $destinationLongitude
     * @param float $destinationLatitude
     * @param float $closestRobotaxiLongitude
     * @param float $closestRobotaxiLatitude
     * @param string $estimatedTimeOfArrival
     * @param int $orderId
     */
    public function __construct( int $orderId, float $pickupLongitude, float $pickupLatitude, float $destinationLongitude, float $destinationLatitude, float $closestRobotaxiLongitude, float $closestRobotaxiLatitude, string $estimatedTimeOfArrival, int $customerId)
    {
        $this->pickupLongitude = $pickupLongitude;
        $this->pickupLatitude = $pickupLatitude;
        $this->destinationLongitude = $destinationLongitude;
        $this->destinationLatitude = $destinationLatitude;
        $this->closestRobotaxiLongitude = $closestRobotaxiLongitude;
        $this->closestRobotaxiLatitude = $closestRobotaxiLatitude;
        $this->estimatedTimeOfArrival = $estimatedTimeOfArrival;
        $this->orderId = $orderId;
        $this->customerId = $customerId;
    }


    /**
     * @return int
     */
    public function getEstimatedTimeOfArrival(): string
    {
        return $this->estimatedTimeOfArrival;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

 /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return float
     */
    public function getPickupLongitude(): float
    {
        return $this->pickupLongitude;
    }

    /**
     * @return float
     */
    public function getPickupLatitude(): float
    {
        return $this->pickupLatitude;
    }

    /**
     * @return float
     */
    public function getDestinationLongitude(): float
    {
        return $this->destinationLongitude;
    }

    /**
     * @return float
     */
    public function getDestinationLatitude(): float
    {
        return $this->destinationLatitude;
    }

    /**
     * @return float
     */
    public function getClosestRobotaxiLongitude(): float
    {
        return $this->closestRobotaxiLongitude;
    }

    /**
     * @return float
     */
    public function getClosestRobotaxiLatitude(): float
    {
        return $this->closestRobotaxiLatitude;
    }


}