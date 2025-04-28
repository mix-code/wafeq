<?php

namespace MixCode\Wafeq\Exceptions;

use Exception;

class WafeqDisabledException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(
        string $message = '',
        int $code = 403,
        ?Exception $previous = null
    ) {
        if (empty($message)) {
            $message = "Wafeq integration is currently disabled.\n"
                . "To enable it, please set WAFEQ_IS_ENABLED=true in your .env file\n"
                . 'and ensure your configuration in config/wafeq.php is correct.';
        }

        parent::__construct($message, $code, $previous);
    }
}
