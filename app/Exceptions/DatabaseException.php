<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DatabaseException extends Exception
{
    public function __construct(string $message = "Save failed!", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
