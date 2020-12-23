<?php

namespace SiteOrigin\Elements;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ElementsServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    /**
     * @throws \ReflectionException
     */
    public function boot()
    {
        Blade::componentNamespace('SiteOrigin\\Elements\\Components', 'elements');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'elements');
    }
}