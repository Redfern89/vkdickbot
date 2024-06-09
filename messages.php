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
		
		WL_DB_Insert('messages', array(
			'from_id' => $from_id,
			'peer_id' => $peer_id,
			'msg_id' => isset($msg_obj['conversation_message_id']) ? $msg_obj['conversation_message_id'] : 0,
			'date' => time(),
			'text' => $text,
			'object_full' => json_encode($msg_obj)
		));

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
					insertTaxonomy($peer_id, $from_id);
					if (!WL_DB_RowExists('dicks', 'vkid', $from_id)) {
						WL_DB_Insert('dicks', array(
							'vkid' => $from_id,
							'first_name' => $userData['first_name'],
							'last_name' => $userData['last_name'],
							'icon' => mt_rand(1, 1047),
							'peer_id' => $peer_id,
							'last_metr' => time(),
							'len' => __('@def_dick_len@'),
							'sex' => 'm',
							'metr_available' => time() -10,
							'photo_50' => $userData['photo_50'],
							'photo_100' => $userData['photo_100'],
							'photo_200' => $userData['photo_200'],
							'probabilities' => json_encode(createProbabilities())
						));
						insertStat($from_id, $peer_id, __('@def_dick_len@'), __('@def_dick_len@'), 'inc');
					}					
					$dick = getDick($from_id);
					$metr_available = $dick['metr_available'];
					$last_metr = $dick['last_metr'];
					$current_time = time();
					$len = (int)$dick['len'];
					$sex = $dick['sex'];
					$probabilities = json_decode($dick['probabilities'], TRUE);

					if ($sex == 'm') {
						if ($len >= __('@small_dick_len@')) {
							$dickName = WL_DB_getField('dick_names', 'name', order: array(['rand', 'id']));
						} else {
							$dickName = WL_DB_getField('small_dick_names', 'name', order: array(['rand', 'id']));
						}
					} else if ($sex == 'f') {
						$dickName = WL_DB_getField('vagina_names', 'name', order: array(['rand', 'id']));
					}

					if ($current_time >= $metr_available) {
						$act = probabilityRandom2(['inc' => 78, 'dec' => 17, 'equ' => 3, 'die' => 1, 'bon' => 1]);
						$val = mt_rand(__('@dick_len_rnd_min@'), __('@dick_len_rnd_max@'));
						$time_counter_rnd = mt_rand(__('@time_rnd_min@'), __('@time_rnd_max@'));
						$statCnt = getStatCnt($from_id);
												
						if ($statCnt >= __('@start_luck_cnt@')) {
							if ($act == 'inc') $len += $val;
							if ($act == 'dec') $len -= $val;
							if ($act == 'equ') {
								$len = $len;
								$val = 0;
							}
							if ($act == 'die') {
								$len = __('@def_dick_len@');
								$val = ($len - (int)__('@def_dick_len@'));
							}
							if ($act == 'bon') {
								$len += __('@bonus_dick_len@');
								$val = __('@bonus_dick_len@');
							}
						} else if ($statCnt < __('@start_luck_cnt@')) {
							$act = 'inc';
							$len += $val;
						}
						
						$s = floor($time_counter_rnd % 60);
						$m = floor($time_counter_rnd / 60);
						$h = floor($time_counter_rnd / 3600);
						
						if ($s == $val || $m == $val || $h == $val) {
							$act = 'god';
							$val = (int)__('@god_dick_len@');
							$len += $val;
						}
						
						$target_time = $current_time + $time_counter_rnd;
						$time_left = $target_time - $current_time;

						insertStat($from_id, $peer_id, $len, $val, $act);
						updateDickScores($from_id, $len, $target_time);

						$dicksAll = WL_DB_GetArray('dicks', 'len');
						$min = min($dicksAll);
						$max = max($dicksAll);
						$progress = getTextProgress($len, $min, $max, TRUE);
						$perc = floor($len * (100 / ($max - $min)));

						$msg = load_tpl(sprintf('%s_dick_action_%s', $sex, $act), array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName,
							'CM' => getMetr($val),
							'LEN' => getMetr($len),
							'BONUS_CM' => getMetr(__('@bonus_dick_len@')),
							'TIME_LEFT' => getTime($time_left),
							'PROGRESS' => $progress,
							'PERC' => $perc
						)); 

						_vkApi_messages_Send($peer_id, $msg);
					} else {
						$time_left = $metr_available - $current_time;
						$target_time = $metr_available - $last_metr;
						$diff_time = $metr_available - $current_time;
						$perc = 100 - floor($diff_time * (100 / $target_time));

						_vkApi_messages_Send($peer_id, load_tpl(sprintf('%s_dick_not_ready', $sex), array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName,
							'TIME_LEFT' => getTime($time_left),
							'PROGRESS' => getTextProgress($diff_time, 0, $target_time),
							'PERC' => $perc,
							'LEN' => getMetr($len)
						)));
					}
				}
				
				if (preg_match('/^пол\s(м|ж)$/siu', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$sex = $cmd_found[1];
						$sexList = array(
							'м' => 'm',
							'ж' => 'f'
						);
						$sex = $sexList[$sex];
						$sexListLang = array(
							'm' => 'мужской',
							'f' => 'женский'
						);
						
						if (WL_DB_RowExists('dicks', 'vkid', $from_id)) {
							WL_DB_Update('dicks', array('sex' => $sex), array(['vkid', '=', $from_id]));
							_vkApi_messages_Send($peer_id, load_tpl('change_sex', array(
								'USERNAME' => $userName,
								'SEX' => $sexListLang[$sex]
							)));
						}
					}
				}
				
				if ($cmd == 'топ') {
					_vkApi_messages_Send($peer_id, load_tpl('top_dicks', array(
						'DICKS_COLLECTION' => metrTopGlobal()
					)), disable_mentions: true);
				}
				
				if ($cmd == 'топчат') {
					if (!$privateMessage) {
						_vkApi_messages_Send($peer_id, load_tpl('top_dicks', array(
							'DICKS_COLLECTION' => metrTop($peer_id)
						)), disable_mentions: true);
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('private_msg_fail', array(
							'USERNAME' => $userName
						)));
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
						if (!empty($photo)) {
							_vkApi_messages_Send($peer_id, load_tpl('stat', array(
								'USERNAME' => $userName
							)), attachment: $photo);
						} else {
							_vkApi_messages_Send($peer_id, load_tpl('fail', array(
								'USERNAME' => $userName
							)));
						}
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('fail', array(
							'USERNAME' => $userName
						)));
					}
				}
				
				if (preg_match('/^стата?\s\[id(\d+)\|.*?\]$/siu', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$id = (int)$cmd_found[1];
						if (WL_DB_RowExists('dicks', 'vkid', $id)) {
							$dickData = getDick($id);
							
							if (!empty($dickData['nick_name'])) {
								$userName = sprintf('[id%d|%s]', $dickData['vkid'], $dickData['nick_name']);
							} else {
								$userName = sprintf('[id%d|%s]', $dickData['vkid'], $dickData['first_name']);
							}

							getDickStatGraph($id);
							$file = DOCROOT . '/stats_graphs/' . $id . '.png';
							if (file_exists($file)) {
								$photo = _vkApi_CreatePhotoAttachment($peer_id, $file, 'image/png');
								if (!empty($photo)) {
									_vkApi_messages_Send($peer_id, load_tpl('stat_user', array(
										'USERNAME' => $userName
									)), attachment: $photo);
								} else {
									// photo api err
									_vkApi_messages_Send($peer_id, load_tpl('fail', array(
										'USERNAME' => $userName
									)));
								}
							} else {
								// file not found
								_vkApi_messages_Send($peer_id, load_tpl('fail', array(
									'USERNAME' => $userName
								)));
							}
						} else {
							// user not found error_user_not_found.tpl
							_vkApi_messages_Send($peer_id, load_tpl('error_user_not_found', array(
								'USERNAME' => $userName
							)));
						}
					}
				}
				
				if ($cmd == 'боги') {
					getGodsStatGraph();
					$file = DOCROOT . '/stats_graphs/gods.png';
					if (file_exists($file)) {
						$topIDS = getTopIDS((int)__('@gods_cnt@'));
						$godsDicks = WL_DB_getRows('dicks', where: array(['vkid', 'IN', implode(',', $topIDS)]), order: array(['len', 'DESC']));
						$godsDicksCollection = array();
						
						if (!empty($godsDicks)) {
							for ($i = 0; $i < count($godsDicks); $i++) {
								$icon = WL_DB_getField('icons', 'data', array(['id', '=', $godsDicks[$i]['icon']]));
								if (!empty($godsDicks[$i]['nick_name'])) {
									$godsDicksCollection[] = sprintf('%d. %s [id%d|%s] - %s', ($i+1), $icon, $godsDicks[$i]['vkid'], $godsDicks[$i]['nick_name'], getMetr($godsDicks[$i]['len']));
								} else {
									$godsDicksCollection[] = sprintf('%d. %s [id%d|%s %s] - %s', ($i+1), $icon, $godsDicks[$i]['vkid'], $godsDicks[$i]['first_name'], $godsDicks[$i]['last_name'], getMetr($godsDicks[$i]['len']));
								}
							}
						}
						
						$photo = _vkApi_CreatePhotoAttachment($peer_id, $file, 'image/png');
						_vkApi_messages_Send($peer_id, load_tpl('gods', array(
							'USERNAME' => $userName,
							'DICKS_COLLECTION' => implode(PHP_EOL, $godsDicksCollection)
						)), attachment: $photo, disable_mentions: TRUE);
					}
				}

				if (preg_match('/^подарить\s\[id(\d+)\|.*?\]\s(\d+)$/siu', $cmd, $cmd_found)) {
					if (isset($cmd_found[1])) {
						$id = $cmd_found[1];
						$error = FALSE;
						$myDick = getDick($from_id);
						$donateLen = (int)$cmd_found[2];

						if (!WL_DB_RowExists('dicks', 'vkid', $id)) {
							_vkApi_messages_Send($peer_id, load_tpl('error_user_not_found', array(
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
							insertStat($from_id, $peer_id, $myDickLen, $donateLen, 'dondec');
							insertStat($id, $peer_id, $donateDickLen, $donateLen, 'doninc');

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
				
				if ($cmd == 'время') {
					if (WL_DB_RowExists('dicks', 'vkid', $from_id)) {
						$dick = getDick($from_id);
						$metr_available = $dick['metr_available'];
						$current_time = time();
						$time_left = $metr_available - $current_time;
						
						if ($time_left > 0) {
							_vkApi_messages_Send($peer_id, load_tpl('time_left', array(
								'USERNAME' => $userName,
								'TIMELEFT' => getTime($time_left)
							)));
						} else {
							$sex = $dick['sex'];
							$len = $dick['len'];
							if ($sex == 'm') {
								if ($len >= __('@small_dick_len@')) {
									$dickName = WL_DB_getField('dick_names', 'name', order: array(['rand', 'id']));
								} else {
									$dickName = WL_DB_getField('small_dick_names', 'name', order: array(['rand', 'id']));
								}
							} else if ($sex == 'f') {
								$dickName = WL_DB_getField('vagina_names', 'name', order: array(['rand', 'id']));
							}
							
							_vkApi_messages_Send($peer_id, load_tpl(sprintf('%s_time_to_ready', $sex), array(
								'USERNAME' => $userName,
								'DICKNAME' => $dickName
							)));
						}
						
					} else {
						// 404 - error_user_not_found
						_vkApi_messages_Send($peer_id, load_tpl('error_user_not_found', array(
							'USERNAME' => $userName
						)));
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
				
				if (preg_match('/^add_(dick|vagina)_names\s(.*)$/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						$organ = $cmd_found[1];
						$names = $cmd_found[2];
						$names = explode(',', $names);
						$items = array();
						
						if (!empty($names)) {
							for ($i = 0; $i < count($names); $i++) {
								$name = trim($names[$i]);
								$items[] = sprintf('%d. %s', ($i +1), $name);
								WL_DB_Insert(sprintf('%s_names', $organ), array('name' => $name));
							}
							_vkApi_messages_Send($peer_id, load_tpl('admin_add_names', array(
								'USERNAME' => $userName,
								'ITEMS' => implode(PHP_EOL, $items)
							)));
						}
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));						
					}
				}
				
				if (preg_match('/^add_(dick|vagina)_name\s(.*)$/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						$organ = $cmd_found[1];
						$name = $cmd_found[2];
						
						WL_DB_Insert(sprintf('%s_names', $organ), array(
							'name' => $name
						));
						
						_vkApi_messages_Send($peer_id, load_tpl('admin_add_dick_name', array(
							'USERNAME' => $userName,
							'DICKNAME' => $name
						)));
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));							
					}
				}
				
				if (preg_match('/^удалить\s\[id(\d+)\|(.*?)\]/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						$id = $cmd_found[1];
						
						WL_DB_Delete('dicks', array(['vkid', '=', $id]));
						WL_DB_Delete('dicks_stats', array(['vkid', '=', $id]));
						WL_DB_Delete('users_peers', array(['user_id', '=', $id]));
						
						_vkApi_messages_Send($peer_id, load_tpl('admin_delete_user', array(
							'USERNAME' => $userName,
							'ACTUSERNAME' => $cmd_found[2]
						)));
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));						
					}
				}
				
				if (preg_match('/^рандом\s(\d+)/siu', $cmd, $cmd_found)) {
					if ($from_id == __('@admin_id@')) {
						$val = $cmd_found[1];
						$id = randomUserIDFromPeer($peer_id);
						$dick = getDick($id);
						$len = $dick['len'];
						$sex = $dick['sex'];
						$len += $val;
						
						if (!empty($dick['nick_name'])) $userName = sprintf('[id%d|%s]', $id, $dick['nick_name']);
						else $userName = sprintf('[id%d|%s]', $id, $dick['first_name']);
						
						if ($sex == 'm') {
							if ($len >= __('@small_dick_len@')) {
								$dickName = WL_DB_getField('dick_names', 'name', order: array(['rand', 'id']));
							} else {
								$dickName = WL_DB_getField('small_dick_names', 'name', order: array(['rand', 'id']));
							}
						} else if ($sex == 'f') {
							$dickName = WL_DB_getField('vagina_names', 'name', order: array(['rand', 'id']));
						}

						updateDickLen($id, $len);
						insertStat($id, $peer_id, $len, $val, 'rndinc');						
						
						_vkApi_messages_Send($peer_id, load_tpl(sprintf('%s_admin_bonus_rnd', $sex), array(
							'USERNAME' => $userName,
							'DICKNAME' => $dickName,
							'VAL' => getMetr($val),
							'LEN' => getMetr($len)
						)));
					} else {
						_vkApi_messages_Send($peer_id, load_tpl('admin_cmd_fail', array(
							'USERNAME' => $userName
						)));						
					}
				}
				
			} // END OF cmd_found
		} // END of is command

	} // END of procedure
?>