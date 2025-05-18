<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class LivroException extends Exception
{
    public function report()
    {
        Log::error("LivroException: " . $this->getMessage());
    }

    public function render($request)
    {
        return response()->view('errors.custom', ['mensagem' => $this->getMessage()], 500);
    }
}
