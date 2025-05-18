<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LivroException extends Exception
{
    /**
     * Reporta o erro para os logs da aplicação.
     *
     * @return void
     */
    public function report(): void
    {
        Log::error('LivroException: ' . $this->getMessage());
    }

    /**
     * Renderiza uma resposta customizada para exceções do tipo LivroException.
     *
     * @param  Request  $request
     * @return Response
     */
    public function render(Request $request): Response
    {
        return response()->view('errors.custom', [
            'mensagem' => $this->getMessage(),
        ], 500);
    }
}
