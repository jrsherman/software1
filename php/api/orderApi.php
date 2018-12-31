<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/25/18
 * Time: 5:25 PM
 */

##The Response library makes it very easy to encapsulate data in a tertiary structure to build the json string more easily
require_once __DIR__ . "/../../lib/Response.php";//where is the response library located
require_once __DIR__ . "/../repository/OrderRepository.php";

$response = new Response();
$method = filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING);

switch ($method) {
    case 'GET':
        if (isset($_GET['orderId'])) {
            $orderId = filter_var($_GET['orderId'], FILTER_SANITIZE_STRING);
            $order = OrderRepository::getOrderById($orderId);
            $response->pushData($order);
            http_response_code(200);
            $response->echoJSONString();
        } else {
            foreach (OrderRepository::getAllOrders() as $order) {
                $response->pushData($order);
            }
            http_response_code(200);
            $response->echoJSONString();
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['orderId'])) {
            $response->pushError("(orderId) was not set for $method!");
        }
        if (!isset($data['pickupLongitude'])) {
            $response->pushError("(pickupLongitude) was not set for $method!");
        }
        if (!isset($data['pickupLatitude'])) {
            $response->pushError("(pickupLatitude) was not set for $method!");
        }
        if (!isset($data['destinationLongitude'])) {
            $response->pushError("(destinationLongitude) was not set for $method!");
        }
        if (!isset($data['destinationLatitude'])) {
            $response->pushError("(destinationLatitude) was not set for $method!");
        }
        if (!isset($data['closestRobotaxiLongitude'])) {
            $response->pushError("(closestRobotaxiLongitude) was not set for $method!");
        }
        if (!isset($data['closestRobotaxiLatitude'])) {
            $response->pushError("(closestRobotaxiLatitude) was not set for $method!");
        }
        if (!isset($data['estimatedTimeOfArrival'])) {
            $response->pushError("(estimatedTimeOfArrival) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $order = new Order($data['pickupLongitude'], $data['pickupLatitude'], $data['destinationLongitude'], $data['destinationLatitude'], $data['closestRobotaxiLongitude'], $data['closestRobotaxiLatitude'], $data['estimatedTimeOfArrival'], $data['orderId']);
            $querySuccess = OrderRepository::updateOrder($order);
            if ($querySuccess) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
        $response->echoJSONString();
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['orderId'])) {
            $response->pushError("(orderId) was not set for $method!");
        }
        if (!isset($data['pickupLongitude'])) {
            $response->pushError("(pickupLongitude) was not set for $method!");
        }
        if (!isset($data['pickupLatitude'])) {
            $response->pushError("(pickupLatitude) was not set for $method!");
        }
        if (!isset($data['destinationLongitude'])) {
            $response->pushError("(destinationLongitude) was not set for $method!");
        }
        if (!isset($data['destinationLatitude'])) {
            $response->pushError("(destinationLatitude) was not set for $method!");
        }
        if (!isset($data['closestRobotaxiLongitude'])) {
            $response->pushError("(closestRobotaxiLongitude) was not set for $method!");
        }
        if (!isset($data['closestRobotaxiLatitude'])) {
            $response->pushError("(closestRobotaxiLatitude) was not set for $method!");
        }
        if (!isset($data['estimatedTimeOfArrival'])) {
            $response->pushError("(estimatedTimeOfArrival) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $order = new Order(-1, $data['pickupLatitude'], $data['destinationLongitude'], $data['destinationLatitude'], $data['closestRobotaxiLongitude'], $data['closestRobotaxiLatitude'], $data['estimatedTimeOfArrival'], $data['orderId']);
            $querySuccess = OrderRepository::insertOrder($order);
            if ($querySuccess) {
                http_response_code(200);
                $response->pushData(['orderId' => EasyDatabase::getLastKey()]);
            } else {
                http_response_code(400);
            }
        } else {
            http_response_code(400);
        }
        $response->echoJSONString();
        break;
    case 'DELETE':
        http_response_code(405);
        $response->echoJSONString();
        break;
    default:
        http_response_code(204);
        $response->echoJSONString();
}


?>