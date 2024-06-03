<?php
	define ('DOCROOT', realpath(__DIR__));
	require_once DOCROOT . '/bootstrap.php';

	function getDickStatGraph2($vkid, $to_browser=false) {
		$img = imagecreatetruecolor(__('@graph_w@'), __('@graph_h@'));
		imageantialias($img, true);
		image_gradientrect2($img, 0, 0, __('@graph_w@'), __('@graph_h@'), __('@graph_bg_start@'), __('@graph_bg_end@'));
		$dickUser = WL_DB_GetRow('dicks', where: array(['vkid', '=', $vkid]));
		$data = array();
		$dataSet = array();

		$paddingLeft = 60;
		$paddingRight = 20;
		$paddingBottom = 90;
		$paddingTop = 40;

		imageline($img, $paddingLeft, $paddingTop, $paddingLeft, (__('@graph_h@') - $paddingBottom), __('@graph_frame_color@'));
		imageline($img, $paddingLeft, (__('@graph_h@') - $paddingBottom), (__('@graph_w@') - $paddingRight), (__('@graph_h@') - $paddingBottom), __('@graph_frame_color@'));
		$points = array(
			$paddingLeft - 5, $paddingTop,
			($paddingLeft), $paddingTop - 10,
			$paddingLeft + 5, $paddingTop
		);
		imagefilledpolygon($img, $points, 3, __('@graph_frame_color@'));
		$points = array(
			((__('@graph_w@') - $paddingRight) + 10), (__('@graph_h@') - $paddingBottom),
			(__('@graph_w@') - $paddingRight), ((__('@graph_h@') - $paddingBottom) - 5),
			(__('@graph_w@') - $paddingRight), (__('@graph_h@') - $paddingBottom) + 5
		);
		imagefilledpolygon($img, $points, 3, __('@graph_frame_color@'));
		$intervalXLines = (__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / (__('@graph_x_lines_cnt@') - 1);
		$intervalXLabels = (__('@graph_w@') - ($paddingLeft + $paddingRight)) / (__('@graph_x_labels_cnt@') - 1);
		
		$intervalYLines = (__('@graph_h@') - ($paddingTop + $paddingBottom)) / (__('@graph_y_lines_cnt@') -1);		

		if (!empty($dickUser)) {
			$dickLengths = WL_DB_GetRows('dicks_stats', where: array(['vkid', '=', $vkid]), count: __('@stat_graph_cnt@'), order: array(['date', 'DESC']));
			$dickLengths = array_reverse($dickLengths);
			for ($i = 0; $i < count($dickLengths); $i++) {
				$data['len'][] = $dickLengths[$i]['len'];
				$data['val'][] = $dickLengths[$i]['val'];
				$data['act'][] = $dickLengths[$i]['act'];
				$data['date'][] = $dickLengths[$i]['date'];
				$dataSet[] = $dickLengths[$i]['len'];
			}

			$nullLine = FALSE;
			if (!empty($dickLengths)) {
				$min = min($dataSet);
				$max = max($dataSet);
				$cnt = count($dataSet);
			} else {
				$min = 0;
				$max = 0;
				$cnt = 0;
				$nullLine = TRUE;
			}
			if ($cnt <= 1) $nullLine = TRUE;

			$color = imagecolorallocatealpha($img, 255, 255, 255, 100);

			if (!empty($dickUser['nick_name'])) $title = sprintf('%s (%dсм.)', $dickUser['nick_name'], $dickUser['len']);
			else $title = sprintf('%s %s (%dсм.)', $dickUser['first_name'], $dickUser['last_name'], $dickUser['len']);

			$titleBbox = imagettfbbox(__('@graph_title_font_size@'), 0, __('@graph_font@'), $title);
			$titleW    = ($titleBbox[2] - $titleBbox[0]);
			$x = (int)((__('@graph_w@') / 2) - (($titleBbox[2] - $titleBbox[0]) / 2));
			$y = (int)(__('@graph_h@') + __('@graph_title_font_size@')) / 2;
			imagettftext($img, __('@graph_title_font_size@'), 0, $x, $y, $color, __('@graph_font@'), $title);

			$lineW = 10;
			$lineH = 10;

			for ($i = 0; $i < __('@graph_x_lines_cnt@'); $i++) {
				$x1 = (int)(($intervalXLines * $i) + $paddingLeft);
				$x2 = $x1;
				$y1 = __('@graph_h@') - $paddingBottom - $lineH;
				$y2 = __('@graph_h@') - $paddingBottom;
				$lineH = ($i % 4) ? 10 : 15;
				
				if ($i < (__('@graph_x_lines_cnt@') -1)) {
					imageline($img, $x1, $y1 -1, $x2, $y2 -1, __('@graph_frame_color@'));
				}
			}
			
			$lbl = '';
			$date = 0;
			$datesCnt = count($data['date']);
			
			for ($i = 0; $i < __('@graph_x_labels_cnt@'); $i++) {
				$x = (int)(($intervalXLabels * $i) + $paddingLeft) - 10;
				$y = __('@graph_h@') -2;
				
				if ($i == 0) $date = $data['date'][0];
				if ($i == (__('@graph_x_labels_cnt@') -1)) $date = end($data['date']);
				if ($i >= 1 && $i <= (__('@graph_x_labels_cnt@') -2)) {
					$dateIdx = floor($i * ($datesCnt) / (__('@graph_x_labels_cnt@') -1));
					$date = $data['date'][$dateIdx];
				}
				
				
				$date_str = date('d.m.Y', $date);
				$time_str = date('H:i:s', $date);
				
				imagettftext($img, __('@graph_font_size@'), 80, $x, $y, __('@graph_text_color@'), __('@graph_font@'), $date_str);
				imagettftext($img, __('@graph_font_size@'), 80, $x+15, $y-5, __('@graph_text_color@'), __('@graph_font@'), $time_str);
			}

			$lbl = '';
			for ($i = 0; $i < __('@graph_y_lines_cnt@'); $i++) {
				if ($i == 0) $lbl = $min;
				if ($i == __('@graph_y_lines_cnt@') -1) $lbl = $max;
				if ($i >= 1 && $i <= (__('@graph_y_lines_cnt@') -2)) 
					$lbl = ($i * ($max - $min) / (__('@graph_y_lines_cnt@') -1)) + $min;
				$lbl = sprintf('%.1f', $lbl);
				$labelsY[] = $lbl;
			}
			$labelsY = array_reverse($labelsY);

			for ($i = 0; $i < __('@graph_y_lines_cnt@'); $i++) {
				$x1 = (int)($paddingLeft);
				$x2 = (int)$x1 + $lineW;
				$y1 = (int)($intervalYLines * $i) + $paddingTop;
				$y2 = (int)$y1;

				if ($i > 0) {
					imageline($img, $x1, $y1, $x2, $y2, __('@graph_frame_color@'));
				}
				$bbox = imagettfbbox(__('@graph_font_size@'), 0, __('@graph_font@'), $labelsY[$i]);
				$textY = $y1 - (($bbox[5] + $bbox[3]) / 2);
				$textX = ($x1 - (__('@graph_font_size@') * 3)) - 10;	
				imagettftext($img, __('@graph_font_size@'), 0, $textX, $textY, __('@graph_text_color@'), __('@graph_font@'), $labelsY[$i]);
			}

			if (!$nullLine) {
				$intervalX = (__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / ($cnt - 1);
			} else {
				$intervalX = 0;
			}

			$acts = array(
				'inc' => '+',
				'dec' => '-',
				'equ' => '=',
				'bon' => '+',
				'die' => '!'
			);

			for ($i = 0; $i < $cnt; $i++) {
				$val = $data['val'][$i];
				$len = $data['len'][$i];
				$act = $acts[$data['act'][$i]];

				$x1 = (int)(($intervalX * $i)) + $paddingLeft;
				if (!$nullLine) {
					$y1 = (int)map($len, $min, $max, (__('@graph_h@') - $paddingBottom), $paddingTop);
				} else {
					$y1 = $paddingBottom;
				}
				if ($i == 0) {
					$x2 = $x1;
					$y2 = $y1;
				}
				if (!$nullLine) {
					imageline($img, $x1, $y1, $x2, $y2, __('@graph_line_color@'));
				}
				$x2 = $x1;
				$y2 = $y1;

				if (!$nullLine) {
					$text = sprintf('%s%d', $act, $val);
					$bbox = imagettfbbox(__('@graph_font_size@'), 0, __('@graph_font@'), $text);
					$textW = -($bbox[0] - $bbox[2]);

					$textX = $x1 - ($textW / 2);
					$textY = $y1;

					if ($i == ($cnt -1)) $textX = $x1 - ($textW);
					if ($textY <= $paddingTop) $textY = $y1 + (__('@graph_font_size@') * 2);
					if ($i == 0) $textX = $paddingLeft;

					if ($i == ($cnt -1) && $len !== $max) {
						$lx1 = $paddingLeft;
						$ly1 = $y1;
						$lx2 = __('@graph_w@') - $paddingRight;
						$ly2 = $y1;
						imagedashedline($img, $lx1, $ly1, $lx2, $ly2, __('@graph_frame_color@'));
					}

					imagettftext($img, __('@graph_font_size@'), 0, $textX, $textY, __('@graph_text_color@'), __('@graph_font@'), $text);
				}
			}
		}

		if ($to_browser) {
			header('Content-Type: image/png');
			imagepng($img);
		} else {
			imagepng($img, DOCROOT . '/stats_graphs/' . $vkid . '.png');
		}
		imagedestroy($img);
	}
	
	getDickStatGraph2(__('@admin_id@'), TRUE);
	
	$sql -> close();
?>