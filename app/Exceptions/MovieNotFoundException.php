<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class MovieNotFoundException extends Exception
{
    protected $message = 'Movie not found.';

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
