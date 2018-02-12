<?php

namespace Craft;

class ImageColorTwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return Craft::t('Image Color');
    }

    public function getFilters()
    {
        return array(
            'imageColor' => new \Twig_Filter_Method($this, 'imageColorFilter')
        );
    }

    public function imageColorFilter($image, $position = 0)
    {
        return craft()->imageColor->getColor($image, $position);
    }
}