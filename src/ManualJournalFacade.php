<?php

namespace MixCode\Wafeq;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MixCode\Wafeq\ManualJournal
 */
class ManualJournalFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'manual_journal';
    }
}
