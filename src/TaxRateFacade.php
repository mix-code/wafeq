<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MixCode\Wafeq\TaxRate
 */
class TaxRateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tax_rate';
    }
}
