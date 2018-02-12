<?php
/**
 * This class can be used to get the most common colors in an image. It needs one parameter: $image, which is the filename of the image you want to process.
 *
 */
class GetMostCommonColors
{
	/**
 * The filename of the image (it can be a JPG, GIF or PNG image)
 *
 * @var string
 */
	var $image;

	/**
	 * Returns the colors of the image in an array, ordered in descending order, where the keys are the colors, and the values are the count of the color.
	 *
	 * @return array
	 */
	function Get_Color()
	{
		if (isset($this->image))
		{
			$PREVIEW_WIDTH    = 150;  //WE HAVE TO RESIZE THE IMAGE, BECAUSE WE ONLY NEED THE MOST SIGNIFICANT COLORS.
			$PREVIEW_HEIGHT   = 150;
			$size = GetImageSize($this->image);
			$scale=1;
			if ($size[0]>0)
			$scale = min($PREVIEW_WIDTH/$size[0], $PREVIEW_HEIGHT/$size[1]);
			if ($scale < 1)
			{
				$width = floor($scale*$size[0]);
				$height = floor($scale*$size[1]);
			}
			else
			{
				$width = $size[0];
				$height = $size[1];
			}
			$image_resized = imagecreatetruecolor($width, $height);
			if ($size[2]==1)
			$image_orig=imagecreatefromgif($this->image);
			if ($size[2]==2)
			$image_orig=imagecreatefromjpeg($this->image);
			if ($size[2]==3)
			$image_orig=imagecreatefrompng($this->image);
			imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1]); //WE NEED NEAREST NEIGHBOR RESIZING, BECAUSE IT DOESN'T ALTER THE COLORS
			$im = $image_resized;
			$imgWidth = imagesx($im);
			$imgHeight = imagesy($im);
			for ($y=0; $y < $imgHeight; $y++)
			{
				for ($x=0; $x < $imgWidth; $x++)
				{
					$index = imagecolorat($im,$x,$y);
					$Colors = imagecolorsforindex($im,$index);
					$Colors['red']=intval((($Colors['red'])+15)/32)*32;    //ROUND THE COLORS, TO REDUCE THE NUMBER OF COLORS, SO THE WON'T BE ANY NEARLY DUPLICATE COLORS!
					$Colors['green']=intval((($Colors['green'])+15)/32)*32;
					$Colors['blue']=intval((($Colors['blue'])+15)/32)*32;
					if ($Colors['red']>=256)
					$Colors['red']=240;
					if ($Colors['green']>=256)
					$Colors['green']=240;
					if ($Colors['blue']>=256)
					$Colors['blue']=240;
					$hexarray[]=substr("0".dechex($Colors['red']),-2).substr("0".dechex($Colors['green']),-2).substr("0".dechex($Colors['blue']),-2);
				}
			}
			$hexarray=array_count_values($hexarray);
			natsort($hexarray);
			$hexarray=array_reverse($hexarray,true);
			return $hexarray;

		}
		else die("You must enter a filename! (\$image parameter)");
	}
}
?>