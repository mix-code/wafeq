<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MixCode\Wafeq\Account
 */
class AccountFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'account';
    }
}
