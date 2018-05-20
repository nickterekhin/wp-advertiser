<?php


namespace TD_Advertiser\src\exceptions;


use Exception;

class TD_Advertiser_Exception extends Exception
{
    /**
     * @param int $action
     * @param string $message
     * @param null $object
     */
    function __construct($message, $action=null, $object=null)
    {
        parent::__construct($message);
    }


}