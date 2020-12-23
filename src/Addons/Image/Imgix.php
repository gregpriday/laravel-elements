<?php

namespace SiteOrigin\Elements\Addons\Image;

use Imgix\UrlBuilder;
use SiteOrigin\Elements\Components\Image;

class Imgix
{
    /**
     * @var \Imgix\UrlBuilder
     */
    private UrlBuilder $builder;

    public function __construct(Image $image)
    {
        $src = parse_url($image->src);
        $this->builder = new UrlBuilder(
            $src['host'],
            $src['scheme'] == 'https',
            '',
            false
        );
    }

    public function filterHtmlAttributes(array $attributes, array $params): array
    {
        // Handle the special case of this value being just "true"
        if(trim($params['params']) == 'true') $params['params'] = '';

        $src = parse_url($attributes['src']);

        $defaultParams = config('elements.imgix.default_params', []);
        $attributeParams = [
            'w' => $attributes['width'],
            'h' => $attributes['height'],
        ];
        $attributeParams = array_filter($attributeParams);
        parse_str($src['query'] ?? '', $srcParams);
        parse_str($params['params'], $elementParams);

        $imgixParams = array_merge($defaultParams, $attributeParams, $srcParams, $elementParams);
        $attributes['src'] = $this->builder->createURL($src['path'], $imgixParams);

        if(isset($params['srcset'])) {
            $attributes['srcset'] = $this->builder->createSrcSet($src['path'], $imgixParams);
        }

        return $attributes;
    }
}