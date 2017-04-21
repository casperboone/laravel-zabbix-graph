# Laravel Zabbix Graph

[![Latest Version on Packagist](https://img.shields.io/packagist/v/casperboone/laravel-zabbix-graph.svg?style=flat-square)](https://packagist.org/packages/casperboone/laravel-zabbix-graph)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/86945098/shield)](https://styleci.io/repos/86945098)
[![Build Status](https://img.shields.io/travis/casperboone/laravel-zabbix-graph/master.svg?style=flat-square)](https://travis-ci.org/casperboone/laravel-zabbix-graph)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/a93de4da-3ccc-4243-bfc0-be924803406c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/a93de4da-3ccc-4243-bfc0-be924803406c)
[![Quality Score](https://img.shields.io/scrutinizer/g/casperboone/laravel-zabbix-graph.svg?style=flat-square)](https://scrutinizer-ci.com/g/casperboone/laravel-zabbix-graph)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/casperboone/laravel-zabbix-graph/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/casperboone/laravel-zabbix-graph/?branch=master)


Get a graph from Zabbix to display on a webpage or to save to a file. If you are not using Laravel, then please check out [this repository](https://github.com/casperboone/zabbix-graph). 


## Installation
You can install the package via composer:

```bash
composer require casperboone/laravel-zabbix-graph
```

You must install the service provider:
```php
// config/app.php
'providers' => [
    ...
    CasperBoone\LaravelZabbixGraph\ZabbixGraphServiceProvider::class,
],
```

If you want to, you can also add the facade:
```php
// config/app.php
'aliases' => [
    ...
    'ZabbixGraph' => CasperBoone\LaravelZabbixGraph\ZabbixGraphFacade::class,
],
```
You can publish the config file with (the [default config file](https://github.com/casperboone/laravel-zabbix-graph/blob/master/config/zabbixgraph.php) will suffice in most cases):
```
php artisan vendor:publish --provider="CasperBoone\LaravelZabbixGraph\ZabbixGraphServiceProvider"
```
Make sure to update the config file or your .env file with the details of your Zabbix server.

## Usage
Output a Zabbix graph to an HTTP endpoint (using method injection):
```php
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use CasperBoone\ZabbixGraph\ZabbixGraph;

class GraphsController extends Controller
{
    public function show(Request $request, ZabbixGraph $zabbixGraph, $id)
    {
        $graph = $zabbixGraph->startTime(Carbon::now()->subDay())
            ->width($request->input('width', 1000))
            ->height($request->input('height', 200))
            ->find($id);

        return response($graph)
            ->header('Content-Type', 'image/png');
    }
}
```

You can also use the facade, if you prefer:
```php
<?php

namespace App\Http\Controllers;

use ZabbixGraph;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraphsController extends Controller
{
    public function show(Request $request, $id)
    {
        $graph = ZabbixGraph::startTime(Carbon::now()->subDay())
            ->width($request->input('width', 1000))
            ->height($request->input('height', 200))
            ->find($id);

        return response($graph)
            ->header('Content-Type', 'image/png');
    }
}
```

For all available methods and options, see [casperboone/zabbix-graph](https://github.com/casperboone/zabbix-graph).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mail@casperboone.nl instead of using the issue tracker.

## Credits

- [Casper Boone](https://github.com/casperboone)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
