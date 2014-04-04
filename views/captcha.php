<?php

if (!isset($_SESSION)) {
	session_start();
}

$width = 220;
$height = 60;
$min_font_size = 22;
$max_font_size = 28;
$angle = 10;
putenv('GDFONTPATH=' . realpath('.'));
$font_path = 'general.ttf';

$temp = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
shuffle($temp);
$temp = array_slice($temp, 0, 5);
$session_var2 = implode('', $temp);
$session_var = implode('', $temp);

if (isset($_GET['id']))
{
	$_SESSION[$_GET['id']] = $session_var2;
}
else
{
	$_SESSION['gen'] = $session_var2;
}

$img = imagecreate( $width, $height );
$black = imagecolorallocate($img,210,210,210);
$line_col = imagecolorallocate($img,240,240,240);
$background = imagecolorallocate($img,240,240,240);

imagefill( $img, 0, 0, $background );	
imagesavealpha($img, TRUE);
imagefilledrectangle($img, 0, 0, 400, 60, $background);
$k = 0;
while ($k<40)
{
	imageline($img, 220, $k*4, 0, $k*4, $line_col);
	$k++;
}


$a = 1;
$len = strlen($session_var);
$space = ($width-10)/$len;

while ($a<=$len)
{
	imagettftext(
		$img,
		rand(
			$min_font_size,
			$max_font_size
			),
		rand( -$angle , $angle ),
		rand( ($space*($a-1))+10, ($space*$a)-10 ),
		rand( $height, $height/2 ),
		$black,
		$font_path,
		substr($session_var,$a-1,1));

	$a++;

}

header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Content-type:image/jpeg");
header("Content-Disposition:inline ; filename=secure.jpg");
imagepng($img,NULL,0);

?>