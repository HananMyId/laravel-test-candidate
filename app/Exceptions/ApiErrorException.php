<?php

namespace App\Exceptions;

use Exception;

class ApiErrorException extends Exception
{
    /**
     * Json encodes the message and calls the parent constructor.
     *
     * @param null           $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(json_encode($message), $code, $previous);
    }

    /**
     * Returns the json decoded message.
     *
     * @param bool $assoc
     *
     * @return mixed
     */
    public function getData($assoc = false)
    {
        return json_decode($this->getMessage(), $assoc);
    }
}
