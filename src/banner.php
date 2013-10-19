<?php

/*
 * This script requires gd, imagick and freetype to function correctly.
*/

function imagettftextshadow($im, $font_size, $angle, $x, $y, $colour, $font, $text, $shadow)
{
	$grey = imagecolorallocate($im, 66, 60, 57);
	imagettftext($im, $font_size, $angle, $x+$shadow, $y+$shadow, $grey, $font, $text);
	imagettftext($im, $font_size, $angle, $x, $y, $colour, $font, $text);
}

function getFrame($text, $text2)
{
	$font = __DIR__.'/minecraft.ttf';
	$im     = imagecreatefrompng(__DIR__."/MCPEBanner.png");

	$colour = imagecolorallocate($im, 191, 187, 238);
	$colour2 = imagecolorallocate($im, 196, 186, 184);

	imagettftextshadow($im, 25, 0, 20, 50, $colour, $font, $text, 4);
	imagettftextshadow($im, 25, 0, 20, 105, $colour2, $font, $text2, 4);
	
	return $im;
}

$GIF = new Imagick();
$GIF->setFormat("gif");

$title = "SurvivalCraft 0.7.5";
$text = "This is a magical world";

$flowtext = array();
$count = 0;

for($i = 0; $i < strlen($text)+1; $i++)
{
	$flowtext[$i] = substr($text, $i, 15);
	if(strlen($flowtext[$i]) < 15)
	{
		$flowtext[$i] = $flowtext[$i].' '.substr($text, 0, $count);
		$count++;
	}
}

foreach($flowtext as $text) {
	$frame = new Imagick();
	$im = getFrame($title."  [0/10]  ".$text, "World on wifi: 192.168.0.1");
	ob_start();
	imagepng($im);
	$blob = ob_get_clean();
	$frame = new Imagick();  
	$frame->readImageBlob($blob);
	$frame->setImageDelay(70);
	$GIF->addImage($frame);
}

header("Content-Type: image/gif");
echo $GIF->getImagesBlob();

//imagepng($im);
//imagedestroy($im);

?>
