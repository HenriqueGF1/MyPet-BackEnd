<?php

namespace App\Exceptions;

use Exception;

class ErroGeralException extends Exception
{
    public function render()
    {
        return response()->json([
            'code' => '400',
            'message' => 'Por favor tente novamente mais tarde.',
            'messageFile' => $this->getFile(),
            'messageLine' => $this->getLine(),
            'messageDev' => $this->getMessage(),
        ]);
    }
}
