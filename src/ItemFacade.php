<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MixCode\Wafeq\Item
 */
class ItemFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'item';
    }
}
