SELECT `dicks`.*, `icons`.`data` AS `icon_emoji` FROM `dicks`
	JOIN `icons` ON `icons`.`id` = `dicks`.`icon`
	WHERE ((ABS(UNIX_TIMESTAMP() - `dicks`.`last_metr`) >= @{inactive_users_seconds}@) AND
			(`dicks`.`len` > 0));