<?php
namespace Craft;

/* require_once(CRAFT_PLUGINS_PATH . 'imagecolor/lib/colorsofimage.class.php'); */

require_once(CRAFT_PLUGINS_PATH . 'imagecolor/lib/colors.inc.php');

class ImageColorService extends BaseApplicationComponent
{
    public function saveColors($image)
    {
        // $imageColor = new \ColorsOfImage( $image->url );
        // $colors = $imageColor->getProminentColors();

        $image_to_read = $image->url;
 
        $pal = new \GetMostCommonColors();
        $pal->image = $image_to_read;
        $colors = $pal->Get_Color();
        $colors_key = array_keys($colors);
        
        $colorRecords = array();
        
        $colors_to_save = 5;
        
        for ($i = 0; $i < $colors_to_save; $i ++) {
            $record = new ImageColorRecord();
            $record->isNewRecord(true);
            $record->setAttributes(array(
                'imageId' => $image->id,
                'color' => '#'.$colors_key[$i]
            ));
            $record->save();
            $colorRecords[] = $record;
        }
        
        return $colorRecords;
    }
    
    public function getColor($image, $position)
    {
        $colorRecord = craft()->db->createCommand()
            ->select('id, imageId, color')
            ->from('imagecolors')
            ->where('imageId = :imageId', array(':imageId' => $image->id))
            ->limit(1)
            ->offset($position)
            ->queryRow();

        if (!$colorRecord) {
            $colorRecord = $this->saveColors($image)[0];
        } 

        return $colorRecord['color'];
    }

    public function getColors($image)
    {
        $colorRecords = craft()->db->createCommand()
            ->select('id, imageId, color')
            ->from('imagecolors')
            ->where('imageId = :imageId', array(':imageId' => $image->id))
            ->queryRow();

        if (!$colorRecords) {
            $colorRecords = $this->saveColors($image);
        }

        return $colorRecords;
    }
}
