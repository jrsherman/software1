<?php
/**
 * 
 * primary key stays as an integer but both username and primary key are unique
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/20/18
 * Time: 8:43 PM
 */

require_once __DIR__ .'/../models/Customer.php';
require_once __DIR__.'/../../lib/EasyDatabase.php';

class CustomerRepository
{

    public static function getCustomerByUsername(string $userName): Customer
    {
        $userName = EasyDatabase::scrubQueryParam($userName);
        //get the raw data from the EasyDatabase
        $rawCustomerDatum = EasyDatabase::query("SELECT * FROM Customer WHERE username='$userName'");
        //our EasyDatabase class will give us a one dimensional array with the result of our query, or an empty array
        //the keys of the array will be the selected columns, in our case all columns
        //now let's make sure we actually got something back
        if ($rawCustomerDatum) {//$rawCustomerDatum is an array with several mapped array values we create a new customer model and fill customer with datapoints on construction
            //return new Customer($rawCustomerDatum['customerId'],$rawCustomerDatum['customerFirstName'], $rawCustomerDatum['customerLastName'], $rawCustomerDatum['username'], $rawCustomerDatum['password']);
        return new Customer($rawCustomerDatum['customerId'],$rawCustomerDatum['customerFirstName'], $rawCustomerDatum['customerLastName'], $rawCustomerDatum['customerLongitude'], $rawCustomerDatum['customerLatitude'], $rawCustomerDatum['username'], $rawCustomerDatum['password']);
            
        }
        //if we couldn't find a Coffee with the given id, return null
       // error_log()
        return null;
    }

    public static function customerExistsByUsername(string $username): bool
    {
          $userName = EasyDatabase::scrubQueryParam($username);
        //get the raw data from the EasyDatabase
        $rawCustomerDatum = EasyDatabase::query("SELECT * FROM Customer WHERE username='$userName'");
        //our EasyDatabase class will give us a one dimensional array with the result of our query, or an empty array
        //the keys of the array will be the selected columns, in our case all columns
        //now let's make sure we actually got something back
        
        if ($rawCustomerDatum) {
        return true;
        }
        return false;
    }

    public static function getCustomerById(int $customerId): Customer
    {
        //We want to make sure to mitigate SQL injection attacks!
        $customerId = EasyDatabase::scrubQueryParam($customerId);
        //get the raw data from the EasyDatabase
        $rawCustomerDatum = EasyDatabase::query("SELECT * FROM Customer WHERE customerId='$customerId'");
        //our EasyDatabase class will give us a one dimensional array with the result of our query, or an empty array
        //the keys of the array will be the selected columns, in our case all columns
        //now let's make sure we actually got something back
        if ($rawCustomerDatum) {
            return new Customer($rawCustomerDatum['customerId'],$rawCustomerDatum['customerFirstName'], $rawCustomerDatum['customerLastName'], $rawCustomerDatum['customerLongitude'], $rawCustomerDatum['customerLatitude'], $rawCustomerDatum['username'], $rawCustomerDatum['password']);
        }
        //if we couldn't find a Coffee with the given id, return null
        return null;
    }

    public static function insertCustomer(Customer $customer) : bool
    {//changed insert into customer to demand
    //making return value an int
        $customerId = $customer->getCustomerId();
        $customerFirstName = $customer->getCustomerFirstName();
        $customerLastName = $customer->getCustomerLastName();
        $customerLongitude = $customer->getCustomerLongitude();
        $customerLatitude = $customer->getCustomerLatitude();
        $username = $customer->getUsername();
        $password = $customer->getPassword();
        //error in the sql had to remove quotes
        //taking out customer Id of insert is inncorect 
        EasyDatabase::query("INSERT INTO Customer (customerFirstName, customerLastName, customerLongitude, customerLatitude, username, password) VALUES ('$customerFirstName', '$customerLastName','$customerLongitude','$customerLatitude', '$username','$password')");
        return true;
        
        //get an empty array 
        //error fix with tj
        /*
       EasyDatabase::query("INSERT INTO Demand (customerFirstName, customerLastName, customerLongitude, customerLatitude, username, password) VALUES ('$customerFirstName', '$customerLastName','$customerLongitude','$customerLatitude', '$username','$password')");
       */
        
        
       /* INSERT INTO Customers (CustomerName, City, Country)
VALUES ('Cardinal', 'Stavanger', 'Norway');
*/
    }

    public static function updateCustomer(Customer $customer) : bool
    {
        $customerId = $customer->getCustomerId();
        $customerFirstName = $customer->getCustomerFirstName();
        $customerLastName = $customer->getCustomerLastName();
        $customerLongitude = $customer->getCustomerLongitude();
        $customerLatitude = $customer->getCustomerLatitude();
        $username = $customer->getUsername();
        $password = $customer->getPassword();

        return EasyDatabase::query("UPDATE Customer SET customerId = '$customerId', customerFirstName = '$customerFirstName', customerLastName = '$customerLastName', customerLongitude = '$customerLongitude', customerLatitude = '$customerLatitude', username = '$username', password = '$password' WHERE customerId = '$customerId'");

    }
    //this is the same as above, except it gets *all* the coffees associated with a species
    public static function getAllCustomers(): array
    {
        //return [new Customer(0, 'John', 'Smith', 0.00, 000, "jsmit", "")];
        $rawCustomerData = EasyDatabase::query("SELECT * FROM Customer");
        if ($rawCustomerData) {
            $output = [];
            foreach ($rawCustomerData as $rawCustomerDatum) {
                $output[] = new Customer($rawCustomerDatum['customerId'], $rawCustomerDatum['customerFirstName'], $rawCustomerDatum['customerLastName'], $rawCustomerDatum['customerLongitude'], $rawCustomerDatum['customerLatitude'], $rawCustomerDatum['username'], $rawCustomerDatum['password']);
            }
            return $output;
        }
        return [];
    }

}