<?php
namespace Craft;

require_once(CRAFT_PLUGINS_PATH . 'imagecolor/lib/colorsofimage.class.php');

class ImageColorService extends BaseApplicationComponent
{
    public function saveColors($image)
    {
    
    	$imageColor = new \ColorsOfImage( $image->url );
		
		$colors = $imageColor->getProminentColors();
	
		$colorRecords = array();
		
		foreach ($colors as $color)
		{
        	$record = new ImageColorRecord();
			$record->setAttributes( array('imageId'=>$image->id, 'color'=>$color ));
			$record->save();
			$colorRecords[] = $record;
		}
	
        return $colorRecords;
    }
    
    public function saveColor($image)
    {
    
    	$imageColor = new \ColorsOfImage( $image->url );
		
		$colors = $imageColor->getProminentColors();
	
	
        $record = new ImageColorRecord();
		$record->setAttributes( array('imageId'=>$image->id, 'color'=>$colors[0] ));
		$record->save();
			
		
        return $record;
    }

    public function getColor($image)
    {
    
    	$colorRecord = craft()->db->createCommand()
                                        ->select('id, imageId, color')
                                        ->from('imagecolors')
                                        ->where('imageId = :imageId', array(':imageId' => $image->id))
                                        ->limit(1)
                                        ->queryRow();

		if (!$colorRecord) {
			$colorRecord = $this->saveColor($image);
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

		if (!$colorRecord) {
			//$colorRecords = $this->saveColors($image);
		}
		
		return $colorRecords;

        
    }
}