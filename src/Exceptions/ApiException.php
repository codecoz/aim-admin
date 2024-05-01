<?php

namespace CodeCoz\AimAdmin\Exceptions;

use Exception;

class ApiException extends Exception
{

    public function __construct($customMessage = null)
    {
        if (is_array($customMessage)) {
            $message = json_encode($customMessage); // Serialize the array to a JSON string
        } else {
            $message = $customMessage ?? 'Resource not found';
        }

        parent::__construct($message);
    }

}
