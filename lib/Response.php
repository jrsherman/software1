<?php
/**
 * Created by IntelliJ IDEA.
 * User: iliashakarzahi
 * Date: 2/28/18
 * Time: 10:28 AM
 */

class Response{

    /**
     * @var array
     */
    private $response = array();


    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->response['errorCount'] = 0;
        $this->response['data'] = array();
    }


    /**
     * @return int
     */
    public function getErrorCount(): int
    {
        return $this->response['errorCount'];
    }

    public function pushData($datum)
    {
        array_push($this->response['data'], $datum);
    }

    /**
     * @return string
     */
    public function echoJSONString()
    {
        header('Content-Type: application/json');
        echo $this->getJSONString();
        return $this->getJSONString();
    }


    /**
     * @return string
     */
    public function getJSONString(): string
    {
        return json_encode($this->response);
    }


    /**
     * @param $errorMessage
     */
    public function pushError($errorMessage)
    {
        $this->response['status'] = "FAIL";
        $this->response['errorCount'] += 1;
        $this->pushError= array_push($this->response['messages'], $errorMessage);
    }
}


