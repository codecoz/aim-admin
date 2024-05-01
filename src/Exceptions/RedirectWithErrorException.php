<?php

namespace CodeCoz\AimAdmin\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class RedirectWithErrorException extends Exception
{
    public function __construct($customMessage = null)
    {
        if (is_array($customMessage)) {
            $message = json_encode($customMessage); // Serialize the array to a JSON string
        } else {
            $message = $customMessage ?? 'Resource not found';
        }

        parent::__construct($message, 404);
    }

    public function render($request): RedirectResponse
    {
        return redirect()->back()->with('error', $this->getMessage());
    }
}
