<?php

namespace MixCode\DaftraClient;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MixCode\DaftraClient\Skeleton\SkeletonClass
 */
class DaftraClientFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'daftra-client';
    }
}
