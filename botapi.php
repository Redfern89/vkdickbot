<?php
	function wl() {
		global $WL;
		$WL['GLOB'] = WL_DB_AssocArray('globals', 'param', 'value');
	}

	function __($param) {
		global $WL;
		if (preg_match('/^@(.*?)@$/', $param, $found)) {
			return (isset($WL['GLOB'][$found[1]]) ? $WL['GLOB'][$found[1]] : $found[1]);
		} //else {
		//	return (isset($WL['LANG'][$param]) ? $WL['LANG'][$param] : $param);
		//}
	}

	function updateGlobal($param, $value) {
		WL_DB_Update('globals', array('value' => $value), array(['param', '=', $param]));
	}

	function __http_request($url, $post_data=null, $proxy=NULL, $addheaders=array()) {
		$ch = curl_init();
		$result = array();

		$proxy_types_map = array(
			'HTTP'		=> CURLPROXY_HTTP,
			'HTTPS'		=> CURLPROXY_HTTPS,
			'SOCKS4'	=> CURLPROXY_SOCKS4,
			'SOCKS4A'	=> CURLPROXY_SOCKS4A,
			'SOCKS5'	=> CURLPROXY_SOCKS5,
		);

		$headers = array(
			'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			//'accept-encoding: gzip, deflate, br',
			'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
			'cache-control: no-cache',
			'dnt: 1',
			'pragma: no-cache',
			'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
		);

		$headers = array_merge($headers, $addheaders);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if (!empty($post_data)) {
			//$post_data = http_build_query($post_data);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIEFILE, DOCROOT . '/tmp/cookies.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, DOCROOT . '/tmp/cookies.txt');

		if ($proxy) {
			list ($proxy_type, $proxy_addr, $proxy_port) = explode(':', $proxy);
			curl_setopt($ch, CURLOPT_PROXY, $proxy_addr);
			curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
			curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_types_map[$proxy_type]);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		}

		try {
			$result = curl_exec($ch);
		} catch (Exception $e) {
			echo $e -> getMessage();
			echo (curl_error($ch));
		}
		curl_close($ch);

		return (!empty($result)) ? $result : false;		
	}

	// Функция генерации случайного числа от 0 до 4294967295
	function random_uint32_t() {
		// Знаю, по-идиотски, но умнее лень было придумывать
		return (int)sprintf('%010d', mt_rand(0, 4294967295));
	}

	function map($x, $in_min, $in_max, $out_min, $out_max) {
		return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
	}

	function image_gradientrect2($img, $x, $y, $w, $h, $start, $end) {
		if ($x > $w || $y > $h) return FALSE;

		$s = array(
			($start >> 16) & 0xFF,
			($start >> 8) & 0xFF,
			$start & 0xFF
		);

		$e = array(
			($end >> 16) & 0xFF,
			($end >> 8) & 0xFF,
			$end & 0xFF
		);

		$steps = $h - $y;
		for($i = 0; $i < $steps; $i++) {
			$r = $s[0] - ((($s[0] - $e[0]) / $steps) * $i);
			$g = $s[1] - ((($s[1] - $e[1]) / $steps) * $i);
			$b = $s[2] - ((($s[2] - $e[2]) / $steps) * $i);
			$color = imagecolorallocate($img, $r, $g, $b);
			imagefilledrectangle($img, $x, $y + $i, $w, $y + $i + 1, $color);
		}
		return true;
	}

	function get_imageType($fname) {
		$types = array(
			1 => 'gif',
			2 => 'jpeg',
			3 => 'png',
			18 => 'webp'
		);
		$result = 0;

		$exif_imagetype = exif_imagetype($fname);
		if ($exif_imagetype == IMAGETYPE_GIF || $exif_imagetype == IMAGETYPE_JPEG || $exif_imagetype == IMAGETYPE_PNG || $exif_imagetype == IMAGETYPE_WEBP) {
			$result = $types[$exif_imagetype];
		}
		return $result;
	}
	
	function imageProgressBar($img, $x, $y, $w, $h, $color=0xFFFFFF, $textColor=0x0d0d0d, $padding=4, $pos=0, $min=0, $max=100) {
		imagerectangle($img, $x, $y, ($x + $w), ($y + $h), $color);
		$progress = map($pos, $min, $max, 1, $w);
		imagefilledrectangle($img, ($x + $padding), ($y + $padding), ($x + $progress - $padding), ($y + $h - $padding), $color);
		
		
		$perc = map($pos, $min, $max, 0, 100);
		$text = sprintf('%d%%', $perc);
		$textBbox = imagettfbbox((int)__('@graph_font_size@'), 0, __('@graph_font@'), $text);
		$textW = ($textBbox[2] - $textBbox[0]);
		$textX = $x + $progress - $textW - 6;
		$textY = ($y + ((int)__('@graph_font_size@'))) + ($h / 2) - (__('@graph_font_size@') / 2) + 1;
		imagettftext($img, (int)__('@graph_font_size@'), 0, $textX, $textY, $textColor, __('@graph_font@'), $text);
		
	}

	function getDickStatGraph($vkid, $to_browser=false) {
		$img = imagecreatetruecolor((int)__('@graph_w@'), (int)__('@graph_h@'));
		imageantialias($img, true);
		image_gradientrect2($img, 0, 0, (int)__('@graph_w@'), (int)__('@graph_h@'), (int)__('@graph_bg_start@'), (int)__('@graph_bg_end@'));
		$dickUser = WL_DB_GetRow('dicks', where: array(['vkid', '=', $vkid]));
		$data = array();
		$dataSet = array();

		$paddingLeft = 60;
		$paddingRight = 20;
		$paddingBottom = 90;
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
		$intervalXLines = ((int)__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / ((int)__('@graph_x_lines_cnt@') - 1);
		$intervalXLabels = ((int)__('@graph_w@') - ($paddingLeft + $paddingRight)) / ((int)__('@graph_x_labels_cnt@') - 1);
		$intervalYLines = ((int)__('@graph_h@') - ($paddingTop + $paddingBottom)) / ((int)__('@graph_y_lines_cnt@') -1);		

		if (!empty($dickUser)) {
			$dickLengths = WL_DB_GetRows('dicks_stats', where: array(['vkid', '=', $vkid]), count: (int)__('@stat_graph_cnt@'), order: array(['date', 'DESC']));
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
			else $title = sprintf("%s %s (%dсм.)", $dickUser['first_name'], $dickUser['last_name'], $dickUser['len']);

			$titleBbox = imagettfbbox((int)__('@graph_title_font_size@'), 0, __('@graph_font@'), $title);
			$titleW    = ($titleBbox[2] - $titleBbox[0]);
			$x = (int)(((int)__('@graph_w@') / 2) - (($titleBbox[2] - $titleBbox[0]) / 2));
			$y = (int)(((int)__('@graph_h@') + (int)__('@graph_title_font_size@')) / 2 - ($paddingBottom));
			imagettftext($img, (int)__('@graph_title_font_size@'), 0, $x, $y, $color, __('@graph_font@'), $title);
			
			$pbW = 500;
			$pbX = (((int)__('@graph_w@') / 2) - ($pbW / 2));
			
			$dicksAll = WL_DB_GetArray('dicks', 'len');
			$pbMin = min($dicksAll);
			$pbMax = max($dicksAll);
			$perc = floor($dickUser['len'] * (100 / ($pbMax - $pbMin)));
			$len = $dickUser['len'];
			
			imageProgressBar($img, $pbX, $y + ((int)__('@graph_title_font_size@') / 2), $pbW, 35, pos: $len, min: $pbMin, max: $pbMax, color: $color);
			
			imagettftext($img, (int)__('@graph_font_size@'), 0, 10, ((int)__('@graph_font_size@') + 8), $color, __('@graph_font@'), sprintf('Samples: %d', (int)__('@stat_graph_cnt@')));

			$lineW = 10;
			$lineH = 10;

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
			
			$lbl = '';
			$date = 0;
			$datesCnt = count($data['date']);
			
			for ($i = 0; $i < (int)__('@graph_x_labels_cnt@'); $i++) {
				$x = (int)(($intervalXLabels * $i) + $paddingLeft) - 10;
				$y = (int)__('@graph_h@') -2;
				
				if ($i == 0) $date = $data['date'][0];
				if ($i == ((int)__('@graph_x_labels_cnt@') -1)) $date = end($data['date']);
				if ($i >= 1 && $i <= ((int)__('@graph_x_labels_cnt@') -2)) {
					$dateIdx = floor($i * ($datesCnt) / ((int)__('@graph_x_labels_cnt@') -1));
					$date = $data['date'][$dateIdx];
				}
				
				
				$date_str = date('d.m.Y', $date);
				$time_str = date('H:i:s', $date);
				
				imagettftext($img, (int)__('@graph_font_size@'), 80, $x, $y, (int)__('@graph_text_color@'), __('@graph_font@'), $date_str);
				imagettftext($img, (int)__('@graph_font_size@'), 80, $x+15, $y-5, (int)__('@graph_text_color@'), __('@graph_font@'), $time_str);
			}

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

			if (!$nullLine) {
				$intervalX = ((int)__('@graph_w@') - ($paddingLeft + $paddingRight) -1) / ($cnt - 1);
			} else {
				$intervalX = 0;
			}

			$acts = array(
				'inc' => '+',
				'dec' => '-',
				'equ' => '=',
				'bon' => '+',
				'die' => '!',
				'god' => '@',
				'doninc' => '*',
				'dondec' => '/',
				'rndinc' => '^'
			);

			for ($i = 0; $i < $cnt; $i++) {
				$val = $data['val'][$i];
				$len = $data['len'][$i];
				$act = $acts[$data['act'][$i]];

				$x1 = (int)(($intervalX * $i)) + $paddingLeft;
				if (!$nullLine) {
					$y1 = (int)map($len, $min, $max, ((int)__('@graph_h@') - $paddingBottom), $paddingTop);
				} else {
					$y1 = $paddingBottom;
				}
				if ($i == 0) {
					$x2 = $x1;
					$y2 = $y1;
				}
				if (!$nullLine) {
					imageline($img, $x1, $y1, $x2, $y2, (int)__('@graph_line_color@'));
				}
				$x2 = $x1;
				$y2 = $y1;

				if (!$nullLine) {
					$text = sprintf('%s%d', $act, $val);
					$bbox = imagettfbbox((int)__('@graph_font_size@'), 0, __('@graph_font@'), $text);
					$textW = -($bbox[0] - $bbox[2]);

					$textX = $x1 - ($textW / 2);
					$textY = $y1;

					if ($i == ($cnt -1)) $textX = $x1 - ($textW);
					//if ($textY <= $paddingTop) $textY = $y1 + ((int)__('@graph_font_size@') * 2);
					if ($i == 0) $textX = $paddingLeft;

					if ($i == ($cnt -1) && $len !== $max) {
						$lx1 = $paddingLeft;
						$ly1 = $y1;
						$lx2 = __('@graph_w@') - $paddingRight;
						$ly2 = $y1;
						//imagedashedline($img, $lx1, $ly1, $lx2, $ly2, (int)__('@graph_frame_color@'));
					}

					imagettftext($img, (int)__('@graph_font_size@'), 0, $textX, $textY, (int)__('@graph_text_color@'), __('@graph_font@'), $text);
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
	
	function randomUserIDFromPeer($peer_id) {
		$data = WL_DB_freeQueryAssoc(load_tpl('sql/donate_rnd_search', array(
			'PEER_ID' => $peer_id
		)));
		return isset($data[0]['vkid']) ? $data[0]['vkid'] : 0;
	}
	
	function metrTopGlobal() {
		$data = WL_DB_freeQueryAssoc(load_tpl('sql/global_top'));
		$result = array();
		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if (!empty($data[$i]['nick_name'])) {
					$result[] = sprintf('%d. %s [id%d|%s] - %s', 
						($i +1),
						$data[$i]['icon_emoji'],
						$data[$i]['vkid'],
						$data[$i]['nick_name'],
						getMetr($data[$i]['len'])
					);
				} else {
					$result[] = sprintf('%d. %s [id%d|%s %s] - %s', 
						($i +1),
						$data[$i]['icon_emoji'],
						$data[$i]['vkid'],
						$data[$i]['first_name'],
						$data[$i]['last_name'],
						getMetr($data[$i]['len'])
					);				
				}
			}
		}
		
		return implode(PHP_EOL, $result);		
	}
	
	function metrTop($peer_id) {
		$data = WL_DB_freeQueryAssoc(load_tpl('sql/top', array(
			'PEER_ID' => $peer_id
		)));
		$result = array();
		
		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if (!empty($data[$i]['nick_name'])) {
					$result[] = sprintf('%d. %s [id%d|%s] - %s', 
						($i +1),
						$data[$i]['icon_emoji'],
						$data[$i]['vkid'],
						$data[$i]['nick_name'],
						getMetr($data[$i]['len'])
					);
				} else {
					$result[] = sprintf('%d. %s [id%d|%s %s] - %s', 
						($i +1),
						$data[$i]['icon_emoji'],
						$data[$i]['vkid'],
						$data[$i]['first_name'],
						$data[$i]['last_name'],
						getMetr($data[$i]['len'])
					);				
				}
			}
		}
		
		return implode(PHP_EOL, $result);
	}
	
	function getInactiveUsersCapacity() {
		$data = WL_DB_freeQueryAssoc(load_tpl('sql/inactive_users_capacity'));
		return isset($data[0]['len']) ? $data[0]['len'] : 0;
	}

	function getInactiveUsersList() {
		$data = WL_DB_freeQueryAssoc(load_tpl('sql/inactive_users_list'));
		$result = array();

		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if (!empty($data[$i]['nick_name'])) $userName = sprintf('[id%d|%s]', $data[$i]['vkid'], $data[$i]['nick_name']);
				else $userName = sprintf('[id%d|%s %s]', $data[$i]['vkid'], $data[$i]['first_name'], $data[$i]['last_name']);
				
				$result[] = sprintf('%d. %s %s - неактивен %s', 
					($i +1),
					$data[$i]['icon_emoji'],
					$userName,
					getTime(time() - $data[$i]['last_metr'], false)
				);
			}
		}

		return implode(PHP_EOL, $result);
	}

	function getMetrTopPhoto($to_browswer=FALSE) {
		$lengthsCollection = array();
		$dicks = WL_DB_GetRows('dicks', count: (int)__('@photo_top_count@'), order: array(['len', 'DESC']));

		if (!empty($dicks)) {
			for ($i = 0; $i < count($dicks); $i++) {
				$lengthsCollection[] = $dicks[$i]['len'];
			}
		}

		$w = 300;
		$h = count($dicks) * (int)__('@photo_top_size@');

		$img = imagecreatetruecolor($w, $h);
		imagefill($img, 0, 0, 0xFFFFFF);

		$x = 0;
		$y = 0;
		$textX = (int)__('@photo_top_size@') + 5;
		$textY = (int)__('@photo_top_font_size@') + 5;
		$dickMin = min($lengthsCollection);
		$dickMax = max($lengthsCollection);

		for ($i = 0; $i < count($dicks); $i++) {			
			$metrPos = ($i + 1);

			if (!empty($dicks[$i]['nick_name'])) $text = sprintf('%d. %s', $metrPos, $dicks[$i]['nick_name']);
			else $text = sprintf('%d. %s %s', $metrPos, $dicks[$i]['first_name'], $dicks[$i]['last_name']);

			imagettftext($img, (int)__('@photo_top_font_size@'), 0, $textX, $textY, 0x00, __('@graph_font@'), $text);
			imagettftext($img, (int)__('@photo_top_font_size@') -2, 0, $textX, $textY + (int)__('@photo_top_font_size@') +5, 0x9f9f9f, __('@graph_font@'), getMetr($dicks[$i]['len']));

			$pbX1 = $textX;
			$pbY1 = $textY + 30;
			$pbX2 = $textX + (int)__('@photo_top_size@') + 85;
			$pbY2 = $pbY1 + 20;

			$pbWMin = 10;
			$pbWMax = (int)__('@photo_top_size@') + 85;

			$pbFillX2 = $pbX1 + map($dicks[$i]['len'], $dickMin, $dickMax, $pbWMin, $pbWMax);

			imagefilledrectangle($img, $pbX1, $pbY1, $pbX2, $pbY2, 0xe3e3e3);
			imagefilledrectangle($img, $pbX1, $pbY1, $pbFillX2, $pbY2, 0x2f6797);

			$file = DOCROOT . '/members/' . (int)__('@photo_top_size@') . '/' . $dicks[$i]['vkid'] . '.jpg';
			$func = sprintf('imagecreatefrom%s', get_imageType($file));
			$photo = $func($file);

			imagecopy($img, $photo, $x, $y, 0, 0, (int)__('@photo_top_size@'), (int)__('@photo_top_size@'));

			$textY += (int)__('@photo_top_size@');
			$y += (int)__('@photo_top_size@');

			imagedestroy($photo);
		}

		if ($to_browswer) {
			header('Content-Type: image/png');
			imagepng($img);
		} else {
			imagepng($img, DOCROOT . '/members/memberstop.png');
		}
		imagedestroy($img);
	}
	
	function getTopIDS($cnt=3) {
		$result = array();

		$ids = WL_DB_getRows('dicks', 'vkid', order: array(['len', 'DESC']), count: $cnt);
		if (!empty($ids)) {
			foreach ($ids as $vkid) {
				$result[] = $vkid['vkid'];
			}
		}
		return $result;
	}
	
	function image_legend($img, $x, $y, array $items = []) {
		$cnt = count($items);
		$textPadding = 10;
		$paddingInner = 10;
		
		$h = ((int)__('@stats_graph_font_size@') * $cnt) + ($textPadding * $cnt) + ($paddingInner * 2);
		$w = 390;
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
	
	function getGodsStatGraph($to_browser=false) {
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
					'bon' => '+',
					'god' => '@',
					'doninc' => '*',
					'dondec' => '/',
					'rndinc' => '^'
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

	function probabilityRandom(array $probabilities) {
		$result = 0;
		$random = mt_rand() / mt_getrandmax();

		foreach ($probabilities as $value => $probability) {
			if ($random < $probability) {
				$result = $value;
			} else {
				$random -= $probability;
			}
		}

		return $result;
	}

	function probabilityRandom2(array $probabilities) {
		$total = array_sum($probabilities);
		$rand = mt_rand(1, $total);
		$current = 0;

		foreach ($probabilities as $key => $value) {
			$current += $value;
			if ($rand <= $current) {
				return $key;
			}
		}
	}

	function true_wordform($num, $arg1, $arg2, $arg3) {
		$num_a = abs($num) % 100;
		$num_x = $num_a % 10;

		if ($num_a > 10 && $num_a < 20) return $arg3;
		if ($num_x > 1 && $num_x < 5) return $arg2;
		if ($num_x == 1) return $arg1;

		return $arg3;
	}

	function getTime($time, $advanced=TRUE) {
		//return $time;
		if ($time <= 59) return sprintf('%d %s', $time, true_wordform($time, 'секунду', 'секунды', 'секунд'));
		if ($time >= 60 && $time < 3600) {
			$s = floor($time % 60);
			$m = floor($time / 60);

			if ($s > 0 && $m > 0) {
				if ($advanced) {
					return sprintf('%d %s и %d %s', 
						$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
						$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
					);
				} else {
					return sprintf('%d %s', 
						$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
					);
					
				}
			} else if ($m > 0 && $s == 0) {
				return sprintf('%d %s', $m, true_wordform($m, 'минута', 'минуты', 'минут'));
			}
		}
		if ($time >= 3600 && $time < 86400) {
			$s = floor($time % 60);
			$m = floor(($time / 60) % 60);
			$h = floor($time / 3600);

			if ($m > 0 && $s > 0) {
				return sprintf('%d %s %d %s и %d %s',
					$h, true_wordform($h, 'час', 'часа', 'часов'),
					$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
					$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
				);
			} else if ($m > 0 && $s == 0) {
				return sprintf('%d %s и %d %s',
					$h, true_wordform($h, 'час', 'часа', 'часов'),
					$m, true_wordform($m, 'минуту', 'минуты', 'минут')
				);
			} else if ($s > 0 && $m == 0) {
				return sprintf('%d %s и %d %s',
					$h, true_wordform($h, 'час', 'часа', 'часов'),
					$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
				);
			} else if ($m == 0 && $s == 0) {
				return sprintf('%d %s', $h, true_wordform($h, 'час', 'часа', 'часов'));
			}
		}
		
		if ($time >= 86400) {
			$s = floor($time % 60);
			$m = floor($time / 60 % 60);
			$h = floor($time % 86400 / 3600);
			$d = floor($time / 86400);
			
			if ($advanced) {
				if ($s > 0 && $m > 0 && $h > 0) {
					return sprintf('%d %s, %d %s %s %s и %d %s',
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$h, true_wordform($h, 'час', 'часа', 'часов'),
						$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
						$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
					);
				} else if ($m > 0 && $h > 0 && $s == 0) {
					return sprintf('%d %s, %d %s и %d %s',
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$h, true_wordform($h, 'час', 'часа', 'часов'),
						$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
					);				
				} else if ($m > 0 && $s > 0 && $m == 0) {
						return sprintf('%d %s, %d %s и %d %s',
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$h, true_wordform($h, 'час', 'часа', 'часов'),
						$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
					);			
				} else if ($s > 0 && $m > 0 && $h == 0) {
					return sprintf('%d %s, %s %s и %d %s',
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$m, true_wordform($m, 'минуту', 'минуты', 'минут'),
						$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
					);
				} else if ($m == 0 && $h == 0 && $s > 0) {
					return sprintf('%d %s и %d %s', 
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$s, true_wordform($s, 'секунду', 'секунды', 'секунд')
					);
				} else if ($h == 0 && $s == 0 && $m > 0) {
						return sprintf('%d %s и %d %s', 
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$m, true_wordform($m, 'минуту', 'минуты', 'минут')
					);	
				} else if ($m == 0 && $s == 0 && $h > 0) {
						return sprintf('%d %s и %d %s', 
						$d, true_wordform($d, 'день', 'дня', 'дней'),
						$h, true_wordform($h, 'час', 'часа', 'часов')
					);					
				} else if ($m == 0 && $h == 0 && $s == 0) {
					return sprintf('%d %s', $d, true_wordform($d, 'день', 'дня', 'дней'));
				}
			} else {
				return sprintf('%d %s', $d, true_wordform($d, 'день', 'дня', 'дней'));
			}
		}
	}
	
	function godTimeValueCompare($time, $value) {
		$s = floor($time % 60);
		$m = floor($time / 60);
		$h = floor($time / 3600);
		
		if ($s == $value || $m == $value || $h == $value) return TRUE;
		return FALSE;
	}

	function getMetr($cm) {
		$signed = FALSE;
		if ($cm < 0) {
			$cm = -$cm;
			$signed = TRUE;
		}

		$signed_str = $signed ? '-' : '';

		if ($cm < 100) return $signed_str . sprintf('%d %s', $cm, true_wordform($cm, 'сантиметр', 'сантиметра', 'сантиметров'));
		if ($cm >= 100 && $cm < 100000) {
			$metrs = floor($cm / 100);
			$cm = $cm % 100;
			
			if ($cm > 0) {
				return $signed_str . sprintf('%d %s и %d %s', 
					$metrs, true_wordform($metrs, 'метр', 'метра', 'метров'),
					$cm, true_wordform($cm, 'сантиметр', 'сантиметра', 'сантиметров')
				);
			} else {
				return $signed_str . sprintf('%d %s', $metrs, true_wordform($metrs, 'метр', 'метра', 'метров'));
			}
		}

		if ($cm >= 100000) {
			$km = floor($cm / 100000);
			$m = floor(($cm % 100000) / 100);
			$cm = ($cm % 100000) % 100;
			
			if ($m > 0 && $cm > 0) {
				return $signed_str . sprintf('%d %s %d %s и %d %s', 
					$km, true_wordform($km, 'километр', 'километра', 'километров'), 
					$m,  true_wordform($m, 'метр', 'метра', 'метров'),
					$cm, true_wordform($cm, 'сантиметр', 'сантиметра', 'сантиметров')
				);
			} else if ($m > 0) {
				return $signed_str . sprintf('%d %s и %d %s', 
					$km, true_wordform($km, 'километр', 'километра', 'километров'), 
					$m,  true_wordform($m, 'метр', 'метра', 'метров')
				);
			} else if ($cm > 0) {
				return $signed_str . sprintf('%d %s и %d %s', 
					$km, true_wordform($km, 'километр', 'километра', 'километров'), 
					$cm, true_wordform($cm, 'сантиметр', 'сантиметра', 'сантиметров')
				);
			} else {
				return $signed_str . sprintf('%d %s', $km, true_wordform($km, 'километр', 'километра', 'километров'));
			}
		}
	}

	function getTextProgress($progressPos, $progressMin=0, $progressMax=100, $reverse=FALSE) {
		$progressCollection = array(
			'[███████████████████]',
			'[██████████████████░]',
			'[█████████████████░░]',
			'[████████████████░░░]',
			'[███████████████░░░░]',
			'[██████████████░░░░░]',
			'[█████████████░░░░░░]',
			'[████████████░░░░░░░]',
			'[███████████░░░░░░░░]',
			'[██████████░░░░░░░░░]',
			'[█████████░░░░░░░░░░]',
			'[████████░░░░░░░░░░░]',
			'[███████░░░░░░░░░░░░]',
			'[██████░░░░░░░░░░░░░]',
			'[█████░░░░░░░░░░░░░░]',
			'[████░░░░░░░░░░░░░░░]',
			'[███░░░░░░░░░░░░░░░░]',
			'[██░░░░░░░░░░░░░░░░░]',
			'[█░░░░░░░░░░░░░░░░░░]',
			'[░░░░░░░░░░░░░░░░░░░]'
		);
		if ($reverse) $progressCollection = array_reverse($progressCollection);

		$progressCollectionCnt = count($progressCollection);
		$x = floor(map($progressPos, $progressMin, $progressMax, 0, ($progressCollectionCnt -1)));
		return $progressCollection[$x];
	}

	function insertStat($vkid, $peer_id, $len, $val, $act) {
		return WL_DB_Insert('dicks_stats', array(
			'vkid' => $vkid,
			'peer_id' => $peer_id,
			'len' => $len,
			'val' => $val,
			'date' => time(),
			'act' => $act
		));
	}
	
	function insertPeer($peer_id) {
		if (!WL_DB_RowExists('peers', 'peer_id', $peer_id)) {
			$peer_data = _vkApi_Call('messages.getConversationsById', array(
				'peer_ids' => $peer_id
			));
			if (isset($peer_data['items'][0]['peer'])) {
				$peer = $peer_data['items'][0]['peer'];
				
				WL_DB_Insert('peers', array(
					'peer_id' => $peer_id,
					'title' => $peer['chat_settings']['title']
				));
			}
		}
	}
	
	function insertTaxonomy($peer_id, $user_id) {
		if (!WL_DB_RowMatch('users_peers', array(['user_id', '=', $user_id], ['peer_id', '=', $peer_id]))) {
			return WL_DB_Insert('users_peers', array(
				'peer_id' => $peer_id,
				'user_id' => $user_id
			));
		}
		
		return 0;
	}
	
	function getStatCnt($vkid) {
		return WL_DB_GetCount('dicks_stats', where: array(['vkid', '=', $vkid]));
	}

	function getDick($vkid) {
		return WL_DB_GetRow('dicks', where: array(['vkid', '=', $vkid]));
	}

	function updateDickScores($vkid, $len, $metr_available) {
		WL_DB_Update('dicks', array('len' => $len, 'last_metr' => time(), 'metr_available' => $metr_available), array(['vkid', '=', $vkid]));
	}

	function updateDickLen($vkid, $len) {
		WL_DB_Update('dicks', array('len' => $len), array(['vkid', '=', $vkid]));
	}
	
	function createProbabilities() {
		return WL_DB_AssocArray('globals', 'lparam', 'value', 'lparam,value', array(['param', 'REGEXP', '^DEF_PROBABILITY_PERC_[a-z]+$']));
	}

	function CRON_ReloadPeerUsers($peer_id) {
		$memebers = _vkApi_Call('messages.getConversationMembers', array(
			'peer_id' => $peer_id
		));

		if (isset($memebers['items'])) {
			if (!empty($memebers['items'])) {

				for ($i = 0; $i < count($memebers['items']); $i++) {
					$item = $memebers['items'][$i];
					$member_id = $item['member_id'];

					if (WL_DB_RowExists('dicks', 'vkid', $member_id)) {
						WL_DB_Insert('users_peers', array(
							'peer_id' => $peer_id,
							'user_id' => $member_id
						));
					}
				}
			}
		}		
	}

	function CRON_reloadPeers() {
		$peers = array();
		WL_DB_CleanTable('users_peers');
		WL_DB_CleanTable('peers');
		
		for ($i = (int)__('@peer_probe_start@'); $i <= (int)__('@peer_probe_end@'); $i++) {
			$peer_id = 2000000000 + $i;
			$peers = _vkApi_Call('messages.getConversationsById', array(
				'peer_ids' => $peer_id
			));
			if (isset($peers['items'][0]['peer'])) {
				$item = $peers['items'][0];
				WL_DB_Insert('peers', array(
					'peer_id' => $item['peer']['id'],
					'title' => $item['chat_settings']['title']
				));
				CRON_ReloadPeerUsers($peer_id);
			}
		}
	}

	function CRON_updateDicks() {
		$dicks = WL_DB_GetDelimitedList('dicks', 'vkid');
		$dicksUsers = _vkApi_Call('users.get', array(
			'user_ids' => $dicks,
			'fields' => 'photo_50,photo_100,photo_200'
		));
		for ($i = 0; $i < count($dicksUsers); $i++) {
			WL_DB_Update('dicks', array(
				'first_name' => $dicksUsers[$i]['first_name'],
				'last_name' => $dicksUsers[$i]['last_name'],
				'photo_50' => $dicksUsers[$i]['photo_50'],
				'photo_100' => $dicksUsers[$i]['photo_100'],
				'photo_200' => $dicksUsers[$i]['photo_200']
			), array(['vkid', '=', $dicksUsers[$i]['id']]));

			file_put_contents(sprintf('%s/members/50/%d.jpg', DOCROOT, $dicksUsers[$i]['id']), file_get_contents($dicksUsers[$i]['photo_50']));
			file_put_contents(sprintf('%s/members/100/%d.jpg', DOCROOT, $dicksUsers[$i]['id']), file_get_contents($dicksUsers[$i]['photo_100']));
			file_put_contents(sprintf('%s/members/200/%d.jpg', DOCROOT, $dicksUsers[$i]['id']), file_get_contents($dicksUsers[$i]['photo_200']));
		}
	}

	function load_tpl(string $tpl, array $params = []) {
		$file = DOCROOT . "/templates/$tpl.tpl";
		$template = '';

		if (file_exists($file)) {
			$template = file_get_contents($file);
			if (!empty($params)) {
				foreach ($params as $param_k => $param_v) {
					$template = str_replace('%{' . $param_k . '}%', $param_v, $template);
				}
			}
			preg_match_all('/@\{(.*?)\}@/isu', $template, $found);
			if (isset($found[1])) {
				for ($i = 0; $i < count($found[1]); $i++) {
					$template = str_replace('@{' . $found[1][$i] . '}@', __('@' . $found[1][$i] . '@'), $template);
				}
			}
			$template = preg_replace('/\%\{.*?\}\%/', '', $template);
		} else {
			die ("Template $tpl.tpl not found");
		}

		return $template;
	}
?>