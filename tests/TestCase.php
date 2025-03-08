<?php

namespace MixCode\DaftraClient\Tests;

use MixCode\DaftraClient\DaftraClientServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Load package service provider.
     */
    protected function getPackageProviders($app)
    {
        return [
            DaftraClientServiceProvider::class,
        ];
    }
}
