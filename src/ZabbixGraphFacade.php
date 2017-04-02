<?php

namespace CasperBoone\LaravelZabbixGraph;

use Illuminate\Support\Facades\Facade;
use CasperBoone\ZabbixGraph\ZabbixGraph;

/**
 * @see \CasperBoone\ZabbixGraph\ZabbixGraph
 */
class ZabbixGraphFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ZabbixGraph::class;
    }
}
