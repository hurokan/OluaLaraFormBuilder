<?php

namespace Rokan\OluaLaraFormBuilder;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rokan\OluaLaraFormBuilder\Skeleton\SkeletonClass
 */
class OluaLaraFormBuilderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'olualaraformbuilder';
    }
}
