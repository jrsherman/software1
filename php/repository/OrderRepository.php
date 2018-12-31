<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/20/18
 * Time: 8:44 PM
 */

require_once __DIR__.'/../../lib/EasyDatabase.php';

require_once __DIR__ .'/../models/Order.php';

class OrderRepository
{
    public static function getOrderById(int $orderId): Order
    {
        //We want to make sure to mitigate SQL injection attacks!
        $orderId = EasyDatabase::scrubQueryParam($orderId);
        //get the raw data from the EasyDatabase
        $rawOrderDatum = EasyDatabase::query("SELECT * FROM `Order` WHERE orderId='$orderId'");
        //our EasyDatabase class will give us a one dimensional array with the result of our query, or an empty array
        //the keys of the array will be the selected columns, in our case all columns
        //now let's make sure we actually got something back
        if ($rawOrderDatum) {
            return new Order($rawOrderDatum['pickupLongitude'], $rawOrderDatum['pickupLatitude'], $rawOrderDatum['destinationLongitude'], $rawOrderDatum['destinationLatitude'], $rawOrderDatum['closestRobotaxiLongitude'], $rawOrderDatum['closestRobotaxiLatitude'], $rawOrderDatum['estimatedTimeOfArrival'], $rawOrderDatum['orderId']);
        }
        return null;
    }
    public static function getAllOrders(): array
    {
        $rawOrderData = EasyDatabase::query("SELECT * FROM `Order`");
        if ($rawOrderData) {
            $output = [];
            foreach ($rawOrderData as $rawOrderDatum) {
                $output[] = new Order($rawOrderDatum['pickupLongitude'], $rawOrderDatum['pickupLatitude'], $rawOrderDatum['destinationLongitude'], $rawOrderDatum['destinationLatitude'], $rawOrderDatum['closestRobotaxiLongitude'], $rawOrderDatum['closestRobotaxiLatitude'], $rawOrderDatum['estimatedTimeOfArrival'], $rawOrderDatum['orderId']);
            }
            return $output;
        }
        return [];
    }
    public static function insertOrder(Order $order) : bool
    {
        $orderId = $order->getOrderId();
        $customerId = $order->getCustomerId();
        $pickupLongitude = $order->getPickupLongitude();
        $pickupLatitude = $order->getPickupLatitude();
        $destinationLongitude = $order->getDestinationLongitude();
        $destinationLatitude = $order->getDestinationLatitude();
        $closestRobotaxiLongitude = $order->getClosestRobotaxiLongitude();
        $closestRobotaxiLatitude = $order->getClosestRobotaxiLatitude();
        $estimatedTimeOfArrival = $order->getEstimatedTimeOfArrival();
//no quotes around Order taking out order id
         EasyDatabase::query("INSERT INTO `Order` (pickupLongitude, pickupLatitude, destinationLongitude, destinationLatitude, closestRobotaxiLongitude, closestRobotaxiLatitude, estimatedTimeOfArrival, customerId) VALUES ('$pickupLongitude', '$pickupLatitude','$destinationLongitude', '$destinationLatitude', '$closestRobotaxiLongitude', '$closestRobotaxiLatitude', '$estimatedTimeOfArrival' , '$customerId')");
        //the values in the ddl rdo not match the values in the Customer repos
       /*EasyDatabase::query("INSERT INTO Order (pickupLongitude, pickupLatitude, destinationLongitude,destinationLatitude, closestRobotaxiLongitude, closestRobotaxiLatitude,estimatedTimeOfArrival) VALUES (2.0,2.0,2.0,2.0,2.0,2.0,2.0)");*/
        
         return true;
         //returned true change with tj

    }

    public static function updateOrder(Order $order) : bool
    {
        $orderId = $order->getOrderId();
        $pickupLongitude = $order->getPickupLongitude();
        $pickupLatitude = $order->getPickupLatitude();
        $destinationLongitude = $order->getDestinationLongitude();
        $destinationLatitude = $order->getDestinationLatitude();
        $closestRobotaxiLongitude = $order->getClosestRobotaxiLongitude();
        $closestRobotaxiLatitude = $order->getClosestRobotaxiLatitude();
        $estimatedTimeOfArrival = $order->getEstimatedTimeOfArrival();

        return EasyDatabase::query("UPDATE `Order` SET orderId = '$orderId', pickupLongitude = '$pickupLongitude', pickupLatitude = '$pickupLatitude', destinationLongitude = '$destinationLongitude', destinationLatitude = '$destinationLatitude', closestRobotaxiLongitude = '$closestRobotaxiLongitude',  closestRobotaxiLatitude = '$closestRobotaxiLatitude', estimatedTimeOfArrival = '$estimatedTimeOfArrival' WHERE orderId = '$orderId'");

    }
}