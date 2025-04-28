<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'endpoint'   => env('WAFEQ_ENDBOINT'),
    'api_key'    => env('WAFEQ_API_KEY'),
    'is_enabled' => env('WAFEQ_IS_ENABLED', false),
];
