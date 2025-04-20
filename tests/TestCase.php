<?php

namespace MixCode\Wafeq\Tests;

use MixCode\Wafeq\WafeqServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Load package service provider.
     */
    protected function getPackageProviders($app)
    {
        return [
            WafeqServiceProvider::class,
        ];
    }
}
