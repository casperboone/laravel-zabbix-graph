<?php

namespace CasperBoone\LaravelZabbixGraph\Test;

use Orchestra\Testbench\TestCase;
use CasperBoone\LaravelZabbixGraph\ZabbixGraphFacade;
use CasperBoone\LaravelZabbixGraph\ZabbixGraphServiceProvider;

class LaravelIntegrationTest extends TestCase
{
    /** @test */
    public function package_provides_zabbix_graph_instance_via_container()
    {
        $graph = app(\CasperBoone\ZabbixGraph\ZabbixGraph::class)->width(1000)->height(500)->find(77);

        $metaData = $this->imageMetaData($graph);

        $this->assertEquals(1116, $metaData['width']); // Graph provided by Zabbix is slightly bigger
        $this->assertEquals(690, $metaData['height']); // Graph provided by Zabbix is slightly bigger
        $this->assertEquals(3, $metaData['type']); // Verify that is a PNG
    }

    /** @test */
    public function package_provides_a_facade()
    {
        $graph = \ZabbixGraph::width(1000)->height(500)->find(77);

        $metaData = $this->imageMetaData($graph);

        $this->assertEquals(1116, $metaData['width']); // Graph provided by Zabbix is slightly bigger
        $this->assertEquals(690, $metaData['height']); // Graph provided by Zabbix is slightly bigger
        $this->assertEquals(3, $metaData['type']); // Verify that is a PNG
    }

    protected function getEnvironmentSetUp($app)
    {
        // Set host to official Zabbix demo
        $app['config']->set('zabbixgraph.host', 'http://zabbix.org/zabbix/');
    }

    protected function getPackageProviders($app)
    {
        return [ZabbixGraphServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'ZabbixGraph' => ZabbixGraphFacade::class,
        ];
    }

    private function imageMetaData($binaryImage)
    {
        $tempFile = tempnam('/tmp', 'image');

        $fileHandle = fopen($tempFile, 'w');
        fwrite($fileHandle, $binaryImage);

        list($width, $height, $type) = getimagesize($tempFile);

        fclose($fileHandle);

        return compact('width', 'height', 'type');
    }
}
