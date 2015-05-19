<?php

namespace Mos\HTMLForm;

/**
 * Form element
 */
class CFormException extends \Exception
{

    /**
     * Constructor
     *
     * @param string    $message  describe the exception.
     * @param int       $code     value of exception.
     * @param Exception $previous exception thrown.
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
         parent::__construct($message, $code, $previous);
    }
}
