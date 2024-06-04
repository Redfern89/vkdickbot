<?php

	function message_process($msg_obj) {
		$text = isset($msg_obj['text']) ? $msg_obj['text'] : '';
		$from_id = isset($msg_obj['from_id']) ? (int)$msg_obj['from_id'] : 0;
		$peer_id = isset($msg_obj['peer_id']) ? (int)$msg_obj['peer_id'] : 0;

		if (empty($text) || $from_id == 0 || $from_id < 0) return;

		$privateMessage = ($peer_id == $from_id) ? TRUE : FALSE;
		$measureActionCommands = ['измерить', 'измерь', 'померить', 'померь'];
		$statActionCommands = ['стата', 'стат', 'статистика'];
		$helpCommands = ['?', 'помощь', 'помоги'];

		if (preg_match(sprintf('/^%s\s(.*)$/siu', __('@bot_cmd@')), $text, $found)) {
			if (isset($found[1])) {
				$cmd = $found[1];
				$userData = _vkApi_usersGet($from_id, fields: 'photo_50,photo_100,photo_200')[0];
				$userName = sprintf('[id%d|%s]', $from_id, $userData['first_name']);

				if (WL_DB_RowExists('dicks', 'vkid', $from_id)) {
					$user = WL_DB_GetRow('dicks', where: array(['vkid', '=', $from_id]));
					if (!empty($user['nick_name'])) $userName = sprintf('[id%d|%s]', $from_id, $user['nick_name']);
				}

				if (in_array(mb_strtolower($cmd), $helpCommands)) {
					_vkApi_messages_Send($peer_id, load_tpl('help', array(
						'BOT_CMD' => __('@bot_cmd@')
					)));
				}

				if (in_array(mb_strtolower($cmd), $measureActionCommands)) {
					if (!WL_DB_RowExists('dicks', 'vkid', $from_id)) {
						WL_DB_Insert('dicks', array(
							'vkid' => $from_id,
							'first_name' => $userData['first_name'],
							'last_name' => $userData['last_name'],
							'icon' => mt_rand(1, 1047),
							'peer_id' => $peer_id,
							'last_metr' => time(),
							'len' => __('@def_dick_len@'),
							'metr_available' => time(),
							'photo_50' => $userData['photo_50'],
							'photo_100' => $userData['photo_100'],
							'photo_200' => $userData['photo_200']
						));
						insertStat($from_id, $peer_id, __('@def_dick_len@'), __('@def_dick_len@'), 'inc');
					}					
					$dick = getDick($from_id);
					$metr_available = $dick['metr_available'];
					$last_metr = $dick['last_metr'];
					$current_time = time();
					$len = $dick['len'];
					
					if ($len >= __('@small_dick_len@')) {
						$dickName = WL_DB_getField('dick_names', 'name', order: array(['rand', 'id']));
					} else {
						$dickName = WL_DB_getField('small_dick_names', 'name', order: array(['rand', 'id']));
					}

					if ($current_time >= $metr_available) {
					//if ($current_time >= 0) {
						$act = probabilityRandom2(['inc' => 78, 'dec' => 17, 'equ' => 3, 'die' => 1, 'bon' => 1]);
						$val = mt_rand(__('@dick_len_rnd_min@'), __('@dick_len_rnd_max@'));
						$time_counter_rnd = mt_rand(__('@time_rnd_min@'), __('@time_rnd_max@'));

						if ($act == 'inc') $len += $val;
						if ($act == 'dec') $len -= $val;
						if ($act == 'equ') $len = $len;
						if ($act == 'die') $len = __('@def_dick_len@');
						if ($act == 'bon') {
							$len += __('@bonus_dick_len@');
							$val = __('@bonus_dick_len@');
						}

						if (getStatCnt($from_id) < __('@start_luck_cnt@')) $act = 'inc';

						$target_time = $current_time + $time_counter_rnd;
						$time_left = $target_time - $current_time;

						insertStat($from_id, $peer_id, $len, $val, $act);
						updateDickScores($from_id, $len, $target_time);

						//$dicksAll = WL_DB_GetArray('dicks', 'len');
						//$min = min($dicksAll);
						//$max = max($dicksAll);
						//$progress = getTextProgress($len, $min, $max, TRUE);
						//$perc = floor($len * (100 / ($max - $min)));

						$msg = load_tpl(sprintf('dick_%s', $act), array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName,
							'CM' => getMetr($val),
							'LEN' => getMetr($len),
							'BONUS_CM' => getMetr(__('@bonus_dick_len@')),
							'TIME_LEFT' => getTime($time_left),
							//'PROGRESS' => $progress,
							//'PERC' => $perc
						));

						_vkApi_messages_Send($peer_id, $msg);
					} else {
						$time_left = $metr_available - $current_time;
						$target_time = $metr_available - $last_metr;
						$diff_time = $metr_available - $current_time;
						$perc = 100 - floor($diff_time * (100 / $target_time));

						_vkApi_messages_Send($peer_id, load_tpl('dick_not_ready', array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName,
							'TIME_LEFT' => getTime($time_left),
							'PROGRESS' => getTextProgress($diff_time, 0, $target_time),
							'PERC' => $perc,
							'LEN' => getMetr($len)
						)));
					}
				}

				if ($cmd == 'топ') {
					$dicks = WL_DB_GetRows('dicks', count: __('@top_count@'), order: array(['len', 'DESC']));
					$dicksCollection = array();

					if (!empty($dicks)) {
						for ($i = 0; $i < count($dicks); $i++) {
							$icon = WL_DB_getField('icons', 'data', array(['id', '=', $dicks[$i]['icon']]));

							if (!empty($dicks[$i]['nick_name'])) $userName = sprintf('[id%d|%s]', $dicks[$i]['vkid'], $dicks[$i]['nick_name']);
							else $userName = sprintf('[id%d|%s %s]', $dicks[$i]['vkid'], $dicks[$i]['first_name'], $dicks[$i]['last_name']);

							$dicksCollection[] = sprintf('%d. %s %s - %s',
								($i+1), 
								$icon,
								$userName,
								getMetr($dicks[$i]['len'])
							);
						}

						_vkApi_messages_Send($peer_id, load_tpl('top_dicks', array(
							'DICKS_COLLECTION' => implode(PHP_EOL, $dicksCollection)
						)), disable_mentions: true);
					}
				}

				if ($cmd == 'top') {
					getMetrTopPhoto();
					$file = DOCROOT . '/members/memberstop.png';
					if (file_exists($file)) {
						$photo = _vkApi_CreatePhotoAttachment($peer_id, $file, 'image/png');
						_vkApi_messages_Send($peer_id, attachment: $photo);
					}
				}

				if (in_array(mb_strtolower($cmd), $statActionCommands)) {
					getDickStatGraph($from_id);
					$file = DOCROOT . '/stats_graphs/' . $from_id . '.png';
					if (file_exists($file)) {
						$photo = _vkApi_CreatePhotoAttachment($peer_id, $file, 'image/png');
						_vkApi_messages_Send($peer_id, load_tpl('stat', array(
							'USERNAME' => $userName
						)), attachment: $photo);
					} else {

					}
				}
				
				if ($cmd == 'боги') {
					getGodsStatGraph();
					$file = DOCROOT . '/stats_graphs/gods.png';
					if (file_exists($file)) {
						$photo = _vkApi_CreatePhotoAttachment($peer_id, $file, 'image/png');
						_vkApi_messages_Send($peer_id, load_tpl('gods', array(
							'USERNAME' => $userName
						)), attachment: $photo);
					}
				}

				if (preg_match('/^подарить\s\[id(\d+)\|.*?\]\s(\d+)$/siu', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$id = $cmd_found[1];
						$error = FALSE;
						$myDick = getDick($from_id);
						$donateLen = (int)$cmd_found[2];

						if (!WL_DB_RowExists('dicks', 'vkid', $id)) {
							_vkApi_messages_Send($peer_id, load_tpl('dick_donate_error_not_found', array(
								'USERNAME' => $userName
							)));
							$error = TRUE;
						}

						if ($from_id == $id && !$error) {
							_vkApi_messages_Send($peer_id, load_tpl('dick_donate_error_to_self', array(
								'USERNAME' => $userName
							)));
							$error = TRUE;					
						}

						if ($myDick['len'] < $donateLen && !$error) {
							$userData = _vkApi_usersGet($id);
							_vkApi_messages_Send($peer_id, load_tpl('dick_donate_error_not_enough_length', array(
								'USERNAME' => $userName,
								'TO_USERNAME' => $userData['first_name'],
								'DONATE_LEN' => getMetr($donateLen),
								'LEN_LEFT' => getMetr($donateLen - $myDick['len']),
								'MY_LEN' => getMetr($myDick['len'])
							)));
							$error = TRUE;
						}

						if ($donateLen < 1 && !$error) {
							_vkApi_messages_Send($peer_id, load_tpl('dick_donate_error_last_than_one_cm', array(
								'USERNAME' => $userName
							)));
							$error = TRUE;
						}

						if ($id == __('@admin_id@') && !$error) {
							_vkApi_messages_Send($peer_id, load_tpl('admin_not_accept', array(
								'USERNAME' => $userName
							)));
							$error = TRUE;
						}

						if (!$error) {
							$myDick = getDick($from_id);
							$donateDick = getDick($id);
							$myDickLen = $myDick['len'];
							$donateDickLen = $donateDick['len'];
							if (!empty($donateDick['nick_name'])) $donateUserName = sprintf('[id%d|%s]', $donateDick['vkid'], $donateDick['nick_name']); 
							else $donateUserName = sprintf('[id%d|%s]', $donateDick['vkid'], $donateDick['first_name']);

							$myDickLen -= $donateLen;
							$donateDickLen += $donateLen;

							updateDickLen($from_id, $myDickLen);
							updateDickLen($id, $donateDickLen);
							insertStat($from_id, $peer_id, $myDickLen, $donateLen, 'dec');
							insertStat($id, $peer_id, $donateDickLen, $donateLen, 'inc');

							_vkApi_messages_Send($peer_id, load_tpl('dick_donate', array(
								'USERNAME' => $donateUserName,
								'FROM_USERNAME' => $userName,
								'DONATE_LEN' => getMetr($donateLen),
								'MY_LEN' => getMetr($myDickLen),
								'LEN' => getMetr($donateDickLen)
							)));
						}
					}
				}

				if (preg_match('/иконка\s(\d+)/siu', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$icon_id = $cmd_found[1];
						if ($icon_id >= 1 && $icon_id <= 1047) {
							$icon = WL_DB_GetField('icons', 'data', array(['id', '=', $icon_id]));
							WL_DB_Update('dicks', array('icon' => $icon_id), array(['vkid', '=', $from_id]));
							_vkApi_messages_Send($peer_id, load_tpl('change_icon', array(
								'USERNAME' => $userName,
								'ICON' => $icon
							)));
						}
					}
				}				

				if (preg_match('/^ник\s(.*)$/su', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$nickname = $cmd_found[1];
						if (mb_strlen($nickname) >= 2 && mb_strlen($nickname) <= 25) {
							WL_DB_Update('dicks', array('nick_name' => $nickname), array(['vkid', '=', $from_id]));
							_vkApi_messages_Send($peer_id, load_tpl('change_nick', array(
								'USERNAME' => $userName,
								'NICKNAME' => $nickname
							)));
						} else {
							
						}
					}
				}

				if (preg_match('/^сброс\s\[id(\d+).*?\]/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						if (isset($cmd_found[1])) {
							$id = $cmd_found[1];
							WL_DB_Update('dicks', array('metr_available' => time()), array(['vkid', '=', $id]));
							$dickData = getDick($id);

							if (!empty($dickData['nick_name'])) {
								$userName = sprintf('[id%d|%s]', $dickData['vkid'], $dickData['nick_name']);
							} else {
								$userName = sprintf('[id%d|%s]', $dickData['vkid'], $dickData['first_name']);
							}

							_vkApi_messages_Send($peer_id, load_tpl('admin_reset_counter', array(
								'USERNAME' => $userName
							)));
						}
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));						
					}
				}

				if (preg_match('/^(прибавить|убавить)\s\[id(\d+).*?\]\s(\d+)$/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						if (isset($cmd_found[1])) {
							$act = $cmd_found[1];
							$id = $cmd_found[2];
							$val = $cmd_found[3];
							$dick = getDick($id);

							if (!empty($dick)) {
								$dickLen = $dick['len'];
								if (!empty($dick['nick_name'])) $userName = sprintf('[id%d|%s]', $dick['vkid'], $dick['nick_name']);
								else $userName = sprintf('[id%d|%s]', $dick['vkid'], $dick['first_name']);
								$actions = array(
									'прибавить' => 'inc',
									'убавить' => 'dec'
								);
								$act = $actions[$act];

								if ($act == 'inc') $dickLen += $val;
								if ($act == 'dec') $dickLen -= $val;
								
								insertStat($id, $peer_id, $dickLen, $val, $act);
								updateDickLen($id, $dickLen);
								
								if ($dickLen >= __('@small_dick_len@')) {
									$dickName = WL_DB_getField('dick_names', 'name', order: array(['rand', 'id']));
								} else {
									$dickName = WL_DB_getField('small_dick_names', 'name', order: array(['rand', 'id']));
								}
								
								_vkApi_messages_Send($peer_id, load_tpl(sprintf('dick_%s_by_admin', $act), array(
									'USERNAME' => $userName,
									'DICKNAME' => $dickName,
									'CM' => getMetr($val),
									'LEN' => getMetr($dickLen)
								)));
							}
						}
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));
					}
				}

				if (preg_match('/^set_global\s(.*?)\s(.*)$/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						if (isset($cmd_found[1])) {
							$param = $cmd_found[1];
							$value = $cmd_found[2];

							if (WL_DB_RowExists('globals', 'param', $param)) {
								updateGlobal($param, $value);
								_vkApi_messages_Send($peer_id, load_tpl('admin_update_param', array(
									'USERNAME' => $userName,
									'PARAM' => $param,
									'VALUE' => $value
								)));
							} else {
								_vkApi_messages_Send($peer_id, load_tpl('admin_update_param_not_found', array(
									'USERNAME' => $userName,
									'PARAM' => $param
								)));
							}
						}
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));						
					}
				}
				
				if (preg_match('/^add_dick_name\s(.*)$/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						$dickName = trim($cmd_found[1]);
						
						WL_DB_Insert('dick_names', array(
							'name' => $dickName
						));
						
						_vkApi_messages_Send($peer_id, load_tpl('admin_add_dick_name', array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName
						)));
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));							
					}
				}
				
				//if ($cmd == 'тест') {
				//	$msg = _vkApi_messages_Send($peer_id, 'хуй');
				//	_vkApi_messages_Pin($peer_id, $msg[0]['conversation_message_id']);
				//}

			} // END OF cmd_found
		}

	}
?>