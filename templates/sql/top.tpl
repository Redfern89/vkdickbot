SELECT 
	`dicks`.*, `icons`.`data` AS `icon_emoji`
		FROM `dicks` 
		JOIN `users_peers` ON `users_peers`.`user_id` = `dicks`.`vkid`
		JOIN `icons` ON `icons`.`id` = `dicks`.`icon`
		WHERE (`users_peers`.`peer_id` = %{PEER_ID}%)
		
	ORDER by `dicks`.`len` DESC LIMIT @{top_count}@;