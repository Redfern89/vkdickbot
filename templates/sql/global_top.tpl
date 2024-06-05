SELECT 	`dicks`.*, `icons`.`data` AS `icon_emoji`
	FROM `dicks`
    JOIN `icons` ON `icons`.`id` = `dicks`.`icon`
    ORDER BY `dicks`.`len` DESC
    LIMIT @{top_count}@;