<?php

namespace SiteOrigin\Elements\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class Base extends Component
{
    private $addons = [];

    public function filterWithAddons($filter, $data)
    {
        if(empty($this->attributes)) return $data;

        $addons = [];
        foreach($this->attributes->getAttributes() as $k => $v) {
            if(strpos($k, ':') === false) continue;

            [$addon, $param] = explode(':', $k);
            if (empty($addons[$addon])) $addons[$addon] = [];
            $param = $param ?: 'use';

            $addons[$addon][$param] = $v;
        }

        foreach($addons as $name => $params) {
            $class = 'SiteOrigin\\Elements\\Addons\\' . class_basename(get_called_class()) . '\\' . Str::studly($name);
            $method = Str::camel('filter-' . $filter);

            if(class_exists($class) && method_exists($class, $method)) {
                if(empty($this->addons[$name])) $this->addons[$name] = (new $class($this));

                // Pass some data, the addon params as well as all other addon params
                $data = $this->addons[$name]->{$method}($data, $params, $addons);
            }
        }

        return $data;
    }

    protected function defaultHtmlAttributes(): array
    {
        return [];
    }

    public function htmlAttributes(): string
    {
        $attributes = $this->filterWithAddons('html-attributes', $this->defaultHtmlAttributes());
        $attributes = array_filter($attributes, fn($a) => !empty($a));

        if (!empty($attributes['class'])) $attributes['class'] = implode(' ', $attributes['class']);

        return implode(' ', array_map(
            fn($k, $v) => $k . '="' . $v . '"',
            array_keys($attributes),
            array_values($attributes)
        ));
    }

    public function render()
    {
        return function($data){
            return view($data['componentName'], $data)->render();
        };
    }
}