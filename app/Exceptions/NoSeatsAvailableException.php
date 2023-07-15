<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NoSeatsAvailableException extends Exception
{
    protected $message = 'No seats available for booking.';

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_BAD_REQUEST);
    }
}
