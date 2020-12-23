<?php

namespace SiteOrigin\Elements\Components;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Image extends Base
{
    public string $src;

    public function __construct(string $src)
    {
        $this->src = $src;
    }

    protected function defaultHtmlAttributes(): array
    {
        return [
            'src' => $this->src,
            'id' => $this->attributes['id'],
            'width' => $this->attributes['width'],
            'height' => $this->attributes['height'],
            'class' => $this->attributes['class'] ? explode(' ', $this->attributes['class']) : []
        ];

    }
}