<?php

namespace SiteOrigin\Elements\Tests;

use SiteOrigin\Elements\ElementsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [ElementsServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('view.paths', [
            __DIR__ . '/views'
        ]);
        $app['config']->set('elements', include(__DIR__.'/../config/elements.php'));
    }

}