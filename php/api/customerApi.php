<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/25/18
 * Time: 5:23 PM
 * trial
 */
require_once __DIR__ . "/../../lib/Response.php";
require_once __DIR__ . "/../repository/CustomerRepository.php";

$response = new Response();
$method = filter_var($_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING);
switch ($method) {
    case 'GET':
        if (isset($_GET['customerId'])) {
            $customerId = filter_var($_GET['customerId'], FILTER_SANITIZE_STRING);
            $customerId = CustomerRepository::getCustomerById($customerId);
            $response->pushData($customerId);
            http_response_code(200);
            $response->echoJSONString();
        } else {
            foreach (CustomerRepository::getAllCustomers() as $customer) {
                $response->pushData($customer);
            }
            http_response_code(200);
            $response->echoJSONString();
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        if (!isset($data['customerId'])) {
            $response->pushError("(customerId) was not set for $method!");
        }
        if (!isset($data['customerFirstName'])) {
            $response->pushError("(customerFirstName) was not set for $method!");
        }
        if (!isset($data['customerLastName'])) {
            $response->pushError("(customerLastName) was not set for $method!");
        }
        if (!isset($data['customerLongitude'])) {
            $response->pushError("(customerLongitude) was not set for $method!");
        }
        if (!isset($data['customerLatitude'])) {
            $response->pushError("(customerLatitude) was not set for $method!");
        }
        if (!isset($data['username'])) {
            $response->pushError("(username) was not set for $method!");
        }
        if (!isset($data['password'])) {
            $response->pushError("(password) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $customer = new Customer($data['customerId'], $data['customerLongitude'], $data['customerLatitude'], $data['customerFirstName'], $data['customerLastName'], $data['username'], $data['password']);
            $querySuccess = CustomerRepository::updateCustomer($customer);
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
        if (!isset($data['customerId'])) {
            $response->pushError("(customerId) was not set for $method!");
        }
        if (!isset($data['customerFirstName'])) {
            $response->pushError("(customerFirstName) was not set for $method!");
        }
        if (!isset($data['customerLastName'])) {
            $response->pushError("(customerLastName) was not set for $method!");
        }
        if (!isset($data['customerLongitude'])) {
            $response->pushError("(customerLongitude) was not set for $method!");
        }
        if (!isset($data['customerLatitude'])) {
            $response->pushError("(customerLatitude) was not set for $method!");
        }
        if (!isset($data['username'])) {
            $response->pushError("(username) was not set for $method!");
        }
        if (!isset($data['password'])) {
            $response->pushError("(password) was not set for $method!");
        }
        if (!$response->getErrorCount()) {
            $customer = new Customer(-1, $data['customerId'], $data['customerFirstName'], $data['customerLastName'], $data['customerLongitude'], $data['customerLatitude'], $data['password']);
            $querySuccess = CustomerRepository::insertCustomer($customer);
            if ($querySuccess) {
                http_response_code(200);
                $response->pushData(['customerId' => EasyDatabase::getLastKey()]);
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