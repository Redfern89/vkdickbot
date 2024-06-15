<?php
		$img = imagecreatetruecolor(400, 400);
		imageantialias($img, true);
		imagefill($img, 0, 0, 0xFFFFFF);
		
		$x = 10;
		$y = 10;
		$w = 100;
		$h = 10;
		$s = 5;
		
		$pointsA1 = array(
			$x, $y,
			$x +3, $y -3,
			$x + 3, $y -3,
			$x + ($w / 2), $y -3,
			$x + (($w / 2) - 2), $y + $h,
			$x + $h, $y + $h
		);

		imagefilledpolygon($img, $pointsA1, 6, 0xFF0000);
		$pointsA2 = array(
			$x + (($w / 2) + $s), $y - 3,
			$x + (($w / 2) + $s - 2), $y + $h,
			$x + ($w + $s - 3) - $h, $y + $h,
			$x + ($w + $s - 3) - $h, $y + $h,
			$x + ($w + $s), $y,
			$x + ($w + $s) - 3, $y - 3
		);
		imagefilledpolygon($img, $pointsA2, 6, 0xFF0000);
		
		$pointsB = array(
			$x + $w + @$_GET['x1'], $y + @$_GET['y1'],
			$x + $w + @$_GET['x2'], $y + @$_GET['y2'],
			$x + $w + @$_GET['x3'], $y + @$_GET['y3'],
			$x + $w + @$_GET['x4'], $y + @$_GET['y4'],
			$x + $w + @$_GET['x5'], $y + @$_GET['y5'],
			$x + $w + @$_GET['x6'], $y + @$_GET['y6'],
			$x + $w + @$_GET['x7'], $y + @$_GET['y7'],
			$x + $w + @$_GET['x8'], $y + @$_GET['y8'],
		);
	
		
		imagepolygon($img, $pointsB, 8, 0x00);
		
		header('Content-Type: image/png');
		imagepng($img);
		imagedestroy($img);
?>