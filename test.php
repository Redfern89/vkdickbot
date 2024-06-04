<?php
	define ('DOCROOT', realpath(__DIR__));
	require_once DOCROOT . '/bootstrap.php';
	

	
	function getArrayMax($array) {
		$countCollection = array();
		if (!empty($array)) {
			foreach($array as $array_) {
				$countCollection[] = count($array_);
			}
		}
		return max($countCollection);
	}

	function image_legend2($img, $x, $y, array $items = []) {
		$cnt = count($items);
		$textPadding = 10;
		$paddingInner = 10;
		
		$h = ((int)__('@stats_graph_font_size@') * $cnt) + ($textPadding * $cnt) + ($paddingInner * 2);
		$w = 300;
		$legend = imagecreatetruecolor($w, $h);
		imagealphablending($legend, false);
		imagesavealpha($legend, true);
		
		$image_color_transparent = imagecolorallocatealpha($legend, 0, 0, 0, 80);
		imagefill($legend, 0, 0, $image_color_transparent);
		
		imagerectangle($legend, 0, 0, ($w -1), ($h -1), 0x7d7d7d);
		
		if (!empty($items)) {
			$colors = array_keys($items);
			$values = array_values($items);
			
			for ($i = 0; $i < count($items); $i++) {
				$x1 = $paddingInner;
				$x2 = $paddingInner + (int)__('@stats_graph_font_size@');
				$y1 = ($i * ($textPadding + 20)) + $paddingInner;
				$y2 = $y1 + (int)__('@stats_graph_font_size@');
				imagefilledrectangle($legend, $x1, $y1, $x2, $y2, $colors[$i]);
				imagerectangle($legend, $x1, $y1, $x2, $y2, 0x00);
				imagettftext($legend, (int)__('@stats_graph_font_size@'), 0, 40, $y2, 0xFFFFFF, __('@graph_font@'), $values[$i]);
			}
		}
		
		imagecopy($img, $legend, $x, $y, 0, 0, $w, $h);
		imagedestroy($img);
	}
	
	function getGodsStatGraph2($to_browser=false) {
		$img = imagecreatetruecolor((int)__('@graph_w@'), (int)__('@graph_h@'));
		imageantialias($img, true);
		image_gradientrect2($img, 0, 0, (int)__('@graph_w@'), (int)__('@graph_h@'), (int)__('@graph_bg_start@'), (int)__('@graph_bg_end@'));
		
		$paddingLeft = 60;
		$paddingRight = 30;
		$paddingBottom = 30;
		$paddingTop = 40;
		
		imageline($img, $paddingLeft, $paddingTop, $paddingLeft, ((int)__('@graph_h@') - $paddingBottom), (int)__('@graph_frame_color@'));
		imageline($img, $paddingLeft, ((int)__('@graph_h@') - $paddingBottom), ((int)__('@graph_w@') - $paddingRight), ((int)__('@graph_h@') - $paddingBottom), (int)__('@graph_frame_color@'));
		$points = array(
			$paddingLeft - 5, $paddingTop,
			($paddingLeft), $paddingTop - 10,
			$paddingLeft + 5, $paddingTop
		);
		imagefilledpolygon($img, $points, 3, (int)__('@graph_frame_color@'));
		$points = array(
			(((int)__('@graph_w@') - $paddingRight) + 10), ((int)__('@graph_h@') - $paddingBottom),
			((int)__('@graph_w@') - $paddingRight), (((int)__('@graph_h@') - $paddingBottom) - 5),
			((int)__('@graph_w@') - $paddingRight), ((int)__('@graph_h@') - $paddingBottom) + 5
		);
		imagefilledpolygon($img, $points, 3, (int)__('@graph_frame_color@'));	
		
		$lineW = 10;
		$lineH = 10;
		
		$intervalXLines = ((int)__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / ((int)__('@graph_x_lines_cnt@') - 1);
		$intervalYLines = ((int)__('@graph_h@') - ($paddingTop + $paddingBottom)) / ((int)__('@graph_y_lines_cnt@') -1);
		
		for ($i = 0; $i < (int)__('@graph_x_lines_cnt@'); $i++) {
			$x1 = (int)(($intervalXLines * $i) + $paddingLeft);
			$x2 = (int)$x1;
			$y1 = (int)__('@graph_h@') - $paddingBottom - $lineH;
			$y2 = (int)__('@graph_h@') - $paddingBottom;
			$lineH = ($i % 4) ? 10 : 15;
			
			if ($i < ((int)__('@graph_x_lines_cnt@') -1)) {
				imageline($img, $x1, $y1 -1, $x2, $y2 -1, (int)__('@graph_frame_color@'));
			}
		}
		
		$topIDS = getTopIDS((int)__('@gods_cnt@'));
		if (!empty($topIDS)) {
			$colors = [0xff0000, 0x00ff00, 0x0000ff, 0xffff00, 0x00ffff, 0xffffff, 0xff00ff];
			$legends = array();
			
			for ($i = 0; $i < count($topIDS); $i++) {
				$user = getDick($topIDS[$i]);
				if (!empty($user['nick_name'])) $name = sprintf('%s (%dсм.)', $user['nick_name'], $user['len']);
				else $name = sprintf('%s %s (%dсм.)', $user['first_name'], $user['last_name'], $user['len']);
				$legends[$colors[$i]] = $name;
			}
			
			image_legend($img, 90, 30, $legends);
			
			$allStats = WL_DB_getRows('dicks_stats', where: array(['vkid', 'IN', implode(',', $topIDS)]), calc_found_rows: false);
			$allDataSet = array();
			
			if (!empty($allStats)) {
				for ($i = 0; $i < count($allStats); $i++) {
					$allDataSet[] = $allStats[$i]['len'];
				}
				
				$min = min($allDataSet);
				$max = max($allDataSet);
				
				$lbl = '';
				for ($i = 0; $i < (int)__('@graph_y_lines_cnt@'); $i++) {
					if ($i == 0) $lbl = $min;
					if ($i == (int)__('@graph_y_lines_cnt@') -1) $lbl = $max;
					if ($i >= 1 && $i <= ((int)__('@graph_y_lines_cnt@') -2)) 
						$lbl = ($i * ($max - $min) / ((int)__('@graph_y_lines_cnt@') -1)) + $min;
					$lbl = sprintf('%.1f', $lbl);
					$labelsY[] = $lbl;
				}
				$labelsY = array_reverse($labelsY);

				for ($i = 0; $i < (int)__('@graph_y_lines_cnt@'); $i++) {
					$x1 = (int)($paddingLeft);
					$x2 = (int)$x1 + $lineW;
					$y1 = (int)($intervalYLines * $i) + $paddingTop;
					$y2 = (int)$y1;

					if ($i > 0) {
						imageline($img, $x1, $y1, $x2, $y2, (int)__('@graph_frame_color@'));
					}
					$bbox = imagettfbbox((int)__('@graph_font_size@'), 0, __('@graph_font@'), $labelsY[$i]);
					$textY = $y1 - (($bbox[5] + $bbox[3]) / 2);
					$textX = ($x1 - ((int)__('@graph_font_size@') * 3)) - 10;	
					imagettftext($img, (int)__('@graph_font_size@'), 0, $textX, $textY, (int)__('@graph_text_color@'), __('@graph_font@'), $labelsY[$i]);
				}
				
				$acts = array(
					'inc' => '+',
					'dec' => '-',
					'equ' => '=',
					'die' => '!',
					'bon' => '+'
				);
				
				for ($i = 0; $i < count($topIDS); $i++) {
					$currentDataSet = WL_DB_getRows('dicks_stats', where: array(['vkid', '=', $topIDS[$i]]), count: (int)__('@gods_graph_cnt@'), order: array(['date', 'DESC']));
					$currentDataSet = array_reverse($currentDataSet);
					$cnt = count($currentDataSet);
					$intervalX = ((int)__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / ($cnt - 1);
					
					if (!empty($currentDataSet)) {
						$c = $colors[$i];
						
						for ($j = 0; $j < count($currentDataSet); $j++) {
							$len = $currentDataSet[$j]['len'];
							$x1 = (int)(($intervalX * $j)) + $paddingLeft;
							$y1 = (int)map($len, $min, $max, ((int)__('@graph_h@') - $paddingBottom), $paddingTop);
							if ($j == 0) {
								$x2 = $x1;
								$y2 = $y1;
							}
							
							imageline($img, $x1, $y1, $x2, $y2, $c);

							
							$act = $acts[$currentDataSet[$j]['act']];
							$val = $currentDataSet[$j]['val'];
							
							$text = sprintf('%s%d', $act, $val);
							$bbox = imagettfbbox((int)__('@graph_font_size@'), 0, __('@graph_font@'), $text);
							$textW = -($bbox[0] - $bbox[2]);

							$textX = $x1 - ($textW / 2);
							$textY = $y1;

							if ($j == ($cnt -1)) $textX = $x1 - ($textW);
							if ($textY <= $paddingTop) $textY = $y1 + ((int)__('@graph_font_size@') * 2);
							if ($j == 0) $textX = $paddingLeft;							
							
							imagettftext($img, (int)__('@graph_font_size@'), 0, $textX, $textY, $c, __('@graph_font@'), $text);
							
							$x2 = $x1;
							$y2 = $y1;
						}
					}
				}
			}
		}
		//exit;
		
		if ($to_browser) {
			header('Content-Type: image/png');
			imagepng($img);
		} else {
			imagepng($img, DOCROOT . '/stats_graphs/gods.png');
		}
		imagedestroy($img);
	}
	
	getGodsStatGraph2(true);
	
	$sql -> close();
?>