SELECT sum(`dicks`.`len`) AS `len` FROM `dicks`
	WHERE ((ABS(UNIX_TIMESTAMP() - `dicks`.`last_metr`) >= @{inactive_users_seconds}@) AND 
			(`dicks`.`len` > 0)
		);