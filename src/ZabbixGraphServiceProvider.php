<?php

namespace CasperBoone\LaravelZabbixGraph;

use Illuminate\Support\ServiceProvider;
use CasperBoone\ZabbixGraph\ZabbixGraph;

class ZabbixGraphServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/zabbixgraph.php' => config_path('zabbixgraph.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/zabbixgraph.php', 'zabbixgraph');

        $this->app->bind(ZabbixGraph::class, function () {
            return new ZabbixGraph(
                $this->app['config']['zabbixgraph.host'],
                $this->app['config']['zabbixgraph.username'],
                $this->app['config']['zabbixgraph.password'],
                $this->app['config']['zabbixgraph.old_version']
            );
        });
    }
}
