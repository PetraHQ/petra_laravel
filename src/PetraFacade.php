<?php

namespace PetraAfrica\Petra;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PetraAfrica\Petra\Skeleton\SkeletonClass
 */
class PetraFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'petra';
    }
}
