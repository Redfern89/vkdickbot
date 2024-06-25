SELECT 
	`dicks`.`vkid` 
	FROM `dicks` 
		JOIN `users_peers` ON `users_peers`.`user_id` = `dicks`.`vkid` AND 
		`users_peers`.`peer_id` = %{PEER_ID}% 
		
		WHERE (`users_peers`.`user_id` != @{admin_id}@) 
		
	ORDER BY rand()
LIMIT 1;