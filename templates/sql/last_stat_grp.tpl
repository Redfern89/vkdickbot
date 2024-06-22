SELECT * FROM (SELECT 
	`dicks_stats`.`date`, 
    DATE(FROM_UNIXTIME(`dicks_stats`.`date`)) AS `grouped_date`, 
    COUNT(`dicks_stats`.`id`) AS `cnt`,
	SUM(
		CASE
		WHEN `dicks_stats`.`act` = 'dec' THEN 0
        WHEN `dicks_stats`.`act` = 'die' THEN 0
		ELSE `dicks_stats`.`val`
		END
	) AS `inc`,
    SUM(
        CASE
        WHEN `dicks_stats`.`act` = 'dec' THEN `dicks_stats`.`val`
        WHEN `dicks_stats`.`act` = 'die' THEN `dicks_stats`.`val`
        END
    ) AS `dec`
	FROM `dicks_stats`
	WHERE 
		(
			(`dicks_stats`.`vkid` = %{ID}%) AND
			(
				(`dicks_stats`.`act` = 'inc') OR
				(`dicks_stats`.`act` = 'dec') OR
				(`dicks_stats`.`act` = 'equ') OR
				(`dicks_stats`.`act` = 'bon') OR
				(`dicks_stats`.`act` = 'god') OR
                (`dicks_stats`.`act` = 'die') OR
				(`dicks_stats`.`act` = 'rndinc')
			)
		)
		GROUP BY `grouped_date`
		ORDER BY `grouped_date` DESC
LIMIT @{bar_chart_limit_cnt}@) AS `subquery` 
ORDER BY `grouped_date` ASC;