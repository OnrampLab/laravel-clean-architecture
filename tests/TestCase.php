<?php

namespace OnrampLab\CleanArchitecture\Tests;

use OnrampLab\CleanArchitecture\CleanArchitectureServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\LaravelData\LaravelDataServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('app.name', 'Test Case');
        $app['config']->set('app.debug', false);
        $app['config']->set('database.default', 'testing_sqlite');
        $app['config']->set('database.connections.testing_sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelDataServiceProvider::class,
            CleanArchitectureServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
        ];
    }
}
