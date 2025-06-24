<?php

namespace MediaWebId\OurWorks\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MediaWebId\OurWorks\OurWorks
 */
class OurWorks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MediaWebId\OurWorks\OurWorks::class;
    }
}
