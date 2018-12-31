<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/8/18
 * Time: 7:07 PM
 */
class Customer
{
    /**
     * @var int
     */
    public $customerId;

    /**
     * @var string
     */
    public $customerFirstName;

    /**
     * @var float
     */
    public $customerLastName;

    /**
     * @var float
     */
    public $customerLongitude;
    /**
     * @var float
     */
    public $customerLatitude;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * Customer constructor.
     * @param int $customerId
     * @param string $customerFirstName
     * @param string $customerLastName
     * @param float $customerLongitude
     * @param float $customerLatitude
     * @param string $username
     * @param string $password
     */
    public function __construct(int $customerId, string $customerFirstName, string $customerLastName, float $customerLongitude, float $customerLatitude, string $username, string $password)
    {
        $this->customerId = $customerId;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
        $this->customerLongitude = $customerLongitude;
        $this->customerLatitude = $customerLatitude;
        $this->username = $username;
        $this->password = $password;
    }
    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }
    /**
     * @return string
     */
    public function getCustomerFirstName(): string
    {
        return $this->customerFirstName;
    }

    /**
     * @return string
     */
    public function getCustomerLastName(): string
    {
        return $this->customerLastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return float
     */
    public function getCustomerLongitude(): float
    {
        return $this->customerLongitude;
    }

    /**
     * @return float
     */
    public function getCustomerLatitude(): float
    {
        return $this->customerLatitude;
    }


}