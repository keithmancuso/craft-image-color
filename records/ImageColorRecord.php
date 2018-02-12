<?php
namespace Craft;

class ImageColorRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'imagecolors';
    }

    protected function defineAttributes()
    {
        return array(
            'imageId' => array(AttributeType::Number,'required' => true),
            'color' => array(AttributeType::String, 'required' => true),
        );
    }
}