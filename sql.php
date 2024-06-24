<?php	
	function WL_DB_QUERY($query) {
		global $sql;
		$result = 0;
		$sql -> query('SET NAMES utf8mb4;');
		$result = $sql -> query($query);
		
		if ($sql -> errno) {
			echo $sql -> error;
			echo '<br>';
			echo '<b>' . $query . '</b>';
		}
		
		return $result;
	}
	
	function WL_DB_freeQueryAssoc($query) {
		$result = array();
		$ch = WL_DB_QUERY($query);
		while ($row = $ch -> fetch_assoc()) {
			$result[] = $row;
		}
		$ch -> close();
		return $result;
	}
	
	function WL_DB_EscapeString($string) {
		global $sql;
		return $sql -> real_escape_string($string);
	}
	
	function WL_DB_getTableFields($table) {
		$table = WL_DB_EscapeString($table);
		$table = '`' . WL_DB . "`.`$table`";
		$ch = WL_DB_QUERY(sprintf('DESCRIBE %s;', $table));
		$result = array();

		while ($row = $ch -> fetch_assoc()) {
			$result[] = $row['Field'];
		}
		$ch -> close();

		return $result;
	}
	
	function WL_DB_CleanTable($table) {
		return WL_DB_QUERY('TRUNCATE `' . WL_DB . '`.`' . WL_DB_EscapeString($table) . '`;');
	}
	
	function WL_DB_CreateWhere($table, $conditions, $summary_logic='AND') {
		$where_collection = array();
		
		$compare_types = ['=', '>', '<', '>=', '<=', 'IN', 'IS', '!=', 'LIKE', 'REGEXP'];
		$condition_types = ['OR', 'AND'];
		
		$table = WL_DB_EscapeString($table);
		$table = '`' . WL_DB . "`.`$table`";
		
		if ($conditions != '*') {
			foreach ($conditions as $condition) {
				$field = WL_DB_EscapeString($condition[0]);
				
				if ($field != 'expr:') {
					$logic = (in_array($condition[1], $compare_types)) ? $condition[1] : '=';
					$value = WL_DB_EscapeString($condition[2]);
					
					if ($logic !== 'IN') {
						if (is_numeric($value)) {
							$where_collection[] = "$table.`$field` $logic $value";
						} else if (is_string($value)) {
							if ($value != 'NULL') {
								$where_collection[] = "$table.`$field` $logic '$value'";
							} else {
								$where_collection[] = "$table.`$field` $logic NULL";
							}
						}
					} else {
						$value = explode(',', $value);
						$in_conditions = array();
						foreach ($value as $fvalue) {
							if (is_numeric($fvalue)) {
								$in_conditions[] = (int)$fvalue;
							} else if (is_string($fvalue)) {
								$in_conditions[] = "'" . WL_DB_EscapeString($fvalue) . "'";
							}
						}
						$where_collection[] = "$table.`$field` IN (" . implode(',', $in_conditions) . ')';
					}
				} else {
					$expr = WL_DB_EscapeString($condition[1]);
					$expr = str_replace('%table%', $table, $expr);
					$where_collection[] = $expr;
				}
				
			}
			
			$where = '(' . implode(" $summary_logic ", $where_collection) . ')';
		} else {
			$where = '1';
		}
		
		return $where;
	}
	
	function WL_DB_CreateLimit($offset=0, $count=0) {
		$limit = '';
		
		$offset = (int)$offset;
		$count = (int)$count;
		
		if ($offset != 0 && $count != 0) {
			$limit = "LIMIT $offset, $count";
		} else if ($count != 0 && $offset == 0) {
			$limit = "LIMIT $count";
		} else if ($offset == 0 && $count == 0) {
			$limit = '';
		}
		
		return $limit;
	}
	
	function WL_DB_CreateGroup($table, $fields) {
		$table = WL_DB_EscapeString($table);
		$groupby_collection = array();
		
		if (!empty($fields)) {
			$fields = explode(',', $fields);
			foreach ($fields as $field) {
				$field = WL_DB_EscapeString($field);
				
				$groupby_collection[] = '`' . WL_DB . "`.`$table`.`$field`";
			}
			
			return 'GROUP BY (' . implode(', ', $groupby_collection) . ')';
		} else {
			return '';
		}
	}
	
	function WL_DB_CreateOrder($table, $fields) {
		$table = WL_DB_EscapeString($table);
		$order_collection = array();
		
		if (!empty($fields)) {
			foreach ($fields as $field) {
				$order_field = WL_DB_EscapeString($field[0]);
				$order_type = in_array($field[1], ['ASC', 'DESC', 'rand']) ? $field[1] : 'ASC';
				
				if ($order_field == 'rand') {
					$order_collection[] = "rand() $order_type";
				} else {
					if (preg_match('/length\//', $order_field)) {
						preg_match('/length\/(.*)/isu', $order_field, $found);
						$order_collection[] = 'LENGTH(`' . WL_DB . "`.`$table`.`{$found[1]}`), {$found[1]} $order_type";
					} else {
						$order_collection[] = '`' . WL_DB . "`.`$table`.`$order_field` $order_type";
					}
				}
			}
			
			return 'ORDER BY ' . implode(', ', $order_collection);
		} else {
			return '';
		}
	}
	
	function WL_DB_SelectTableFields($table, $fields) {
		$table = WL_DB_EscapeString($table);
		$fields_collection = array();
		$fields = ($fields != '*') ? explode(',', $fields) : '*';
		
		if (is_array($fields)) {
			foreach($fields as $field) {
				$field = WL_DB_EscapeString($field);
				$fields_collection[] = '`' . WL_DB . "`.`$table`.`$field`";
			}
		} else {
			$fields_collection[] = '`' . WL_DB . "`.`$table`.*";
		}
		
		return implode(', ', $fields_collection);
	}
	
	function WL_DB_UpdateFields($table, $fields) {
		$table = WL_DB_EscapeString($table);
		$update_collection = array();
		
		if (!empty($fields)) {
			foreach($fields as $field => $value) {
				$field = WL_DB_EscapeString($field);
				$value = WL_DB_EscapeString($value);
				
				if (preg_match('/expr:/', $value)) {
					preg_match('/expr:(.*)/', $value, $found);
					if (isset($found[1])) {
						$update_collection[] = '`' . WL_DB . "`.`$table`.`$field` = {$found[1]}";
					}
				} else {
					if ($value != 'NULL') {
						$update_collection[] = '`' . WL_DB . "`.`$table`.`$field` = '$value'";
					} else {
						$update_collection[] = '`' . WL_DB . "`.`$table`.`$field` = NULL";
					}
					
					//if (is_integer($value)) $update_collection[] = sprintf('`%s`.`%s`.`%s` = %d', WL_DB, $table, $field, $value);
				}
			}
		}
		
		return implode(', ', $update_collection);
	}
	
    function WL_DB_Create_MatchAgainst($table, $words, $cells_data, $between_cells_logic='OR') {
        $match_expr = array();
        $cells_expr = array();
        $words = strlen($words) ? explode(' ', $words) : [];
        
        if (count($words)) {
            for ($i = 0; $i < count($cells_data); $i++) {
                $cell_logic = $cells_data[$i][1];
                $cells = explode(',', $cells_data[$i][0]);
                
                for ($j = 0; $j < count($cells); $j++) {
                    
                    if (count($words)) {
                        for ($x = 0; $x < count($words); $x++) {
                            $word = WL_DB_EscapeString($words[$x]);
							$match_expr[$i][] = "(MATCH `$table`.`{$cells[$j]}` AGAINST ('$word*' IN BOOLEAN MODE))"; 
                        }
                    }
                    $cells_expr[] = '(' . implode(" $cell_logic ", $match_expr[$i]) . ')';
					$match_expr = array();
                
                }
                
            }
            return '(' . implode(" $between_cells_logic ", $cells_expr) . ')';

        } else {
            return '1';
        }
    }
	
	function WL_DB_Create_Taxonomy2($table, $data) {
		$table				= WL_DB_EscapeString($table);
		$table				= '`' . WL_DB . "`.`$table`";
		$join_collection	= array();
		
		if (!empty($data)) {
			for ($i = 0; $i < count($data); $i++) {
				if (!empty($data[$i])) {
					$jointable	= WL_DB_EscapeString($data[$i][0]);
					$terms		= WL_DB_EscapeString($data[$i][1]);
					$terms		= explode(',', $terms);
					$obj_type	= WL_DB_EscapeString($data[$i][2]);
					$terms_cnt	= 0;
					
					if (!empty($terms)) {
						for ($j = 0; $j < count($terms); $j++) {
							$c = count($join_collection);
							$join_collection[] = 'JOIN `' . TTAXONOMY . "` AS `tt$c` ON `tt$c`.`object_id` = $table.`id` AND `tt$c`.`obj_type` = '$obj_type' JOIN `$jointable` AS `t$c` ON `tt$c`.`term_id` = `t$c`.`id` AND `t$c`.`term` = '{$terms[$j]}'";
						}
					}
				}
			}
			
			return implode(' ', $join_collection);
		}
	}
	
	function WL_DB_Taxonomy($table, $jointable, $terms, $obj_type, $logic) {		
		$table		=	WL_DB_EscapeString($table);
		$jointable	=	WL_DB_EscapeString($jointable);
		$obj_type	=	WL_DB_EscapeString($obj_type);
		$logic		=	WL_DB_EscapeString($logic);
		
		$terms_collection		= array();
		$join_expr_collection	= array();
		$terms_expr_collection	= array();
		
		$result = '';
		
		if (!empty($terms)) {
			$terms_collection = explode(',', $terms);
			
			if ($logic == 'AND') {
				for ($i = 0; $i < count($terms_collection); $i++) {
					$term = WL_DB_EscapeString($terms_collection[$i]);
					$join_expr_collection[] = 'JOIN `' . TTAXONOMY . "` AS `tt$i` ON `tt$i`.`object_id` = `$table`.`id` AND `tt$i`.`obj_type` = '$obj_type' JOIN `$jointable` AS `t$i` ON `t$i`.`id` = `tt$i`.`term_id` AND `t$i`.`name` = '$term'";
				}
				$result = implode(' ', $join_expr_collection);
			} else if ($logic == 'OR') {
				for ($i = 0; $i < count($terms_collection); $i++) {
					$term = WL_DB_EscapeString($terms_collection[$i]);
					$terms_expr_collection[] = "'$term'";
				}
				$result = 'JOIN `' . TTAXONOMY . '` ON `' . TTAXONOMY . '`.`object_id` = `' . $table . '`.`id` AND `' . TTAXONOMY . '`.`obj_type` = \'' . $obj_type . '\' JOIN `' . $jointable . '` ON `' . TTAXONOMY . '`.`term_id` = `' . $jointable . '`.`id` AND `' . $jointable . '`.`name` IN (' . implode(',', $terms_expr_collection) . ')';
			}
		}
		
		return $result;
	}	
	
	function WL_DB_GetRows($table, $fields='*', $where='*', $callback=null, $summary_logic='AND', $order='', $group='', $offset=0, $count=0, $calc_found_rows=TRUE, $echo=FALSE) {
		$result = array();
		
		$table = WL_DB_EscapeString($table);
		$fields = WL_DB_SelectTableFields($table, $fields);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		$order = WL_DB_CreateOrder($table, $order);
		$group = WL_DB_CreateGroup($table, $group);
		$limit = WL_DB_CreateLimit($offset, $count);
		
		
		if ($calc_found_rows) $q = "SELECT SQL_CALC_FOUND_ROWS $fields FROM `$table` WHERE $where $order $group $limit;";
		if (!$calc_found_rows) $q = "SELECT $fields FROM `$table` WHERE $where $order $group $limit;";
		if ($echo) echo $q;
		$ch = WL_DB_QUERY($q);
		
		while ($sql_result = $ch -> fetch_assoc()) {
			if (isset($callback) && is_callable($callback)) {
				$callback($sql_result);
			} else {
				$result[] = $sql_result;
			}
		}
		
		$ch -> close();
		
		return $result;
	}
	
	function WL_DB_GetRow($table, $fields='*', $where='*', $callback=null, $summary_logic='AND', $order='') {
		$result = array();
		
		$table = WL_DB_EscapeString($table);
		$fields = WL_DB_SelectTableFields($table, $fields);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		$order = WL_DB_CreateOrder($table, $order);
		$limit = WL_DB_CreateLimit(0, 1);
		
		$q = "SELECT $fields FROM `$table` WHERE $where $order $limit;";
		$ch = WL_DB_QUERY($q);
		
		while ($sql_result = $ch -> fetch_assoc()) {
			if (isset($callback)) {
				$callback($sql_result);
			} else {
				$result = $sql_result;
			}
		}
		
		$ch -> close();
		
		return $result;		
	}
	
	function WL_DB_GetField($table, $field, $where='*', $order='', $summary_logic='AND') {
		$result = '';
		$table = WL_DB_EscapeString($table);
		$fields = WL_DB_SelectTableFields($table, $field);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		$order = WL_DB_CreateOrder($table, $order);
		$limit = WL_DB_CreateLimit(0, 1);
		
		$q = "SELECT $fields FROM `$table` WHERE $where $order $limit;";
		$ch = WL_DB_QUERY($q);
		$sql_result = $ch -> fetch_assoc();
		$ch -> close();
	
		$result = isset($sql_result[$field]) ? $sql_result[$field] : '';
		
		return $result;
	}
	
	function WL_DB_GetCount($table, $field='id', $where='*', $summary_logic='AND', $group='') {
		$result = '';
		$table = WL_DB_EscapeString($table);
		$field = WL_DB_EscapeString($field);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		$group = WL_DB_CreateGroup($table, $group);
		
		$q = 'SELECT COUNT(`' . WL_DB . "`.`$table`.`$field`) AS `count` FROM `$table` WHERE $where $group;";
		$ch = WL_DB_QUERY($q);
		$sql_result = $ch -> fetch_assoc();
		$ch -> close();
	
		$result = isset($sql_result['count']) ? (int)$sql_result['count'] : 0;
		
		return $result;		
	}
	
	function WL_DB_Update($table, $fields, $where='*', $summary_logic='AND') {
		$table = WL_DB_EscapeString($table);
		$fields = WL_DB_UpdateFields($table, $fields);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		
		$q = "UPDATE `$table` SET $fields WHERE $where";
		
		WL_DB_QUERY($q);
	}
	
	function WL_DB_Delete($table, $where, $summary_logic='AND') {
		$table = WL_DB_EscapeString($table);
		$where = WL_DB_CreateWhere($table, $where, $summary_logic);
		
		$q = "DELETE FROM `$table` WHERE $where;";
		WL_DB_QUERY($q);
	}
	
	function WL_DB_Insert($table, $fields, $echo=FALSE) {
		global $sql;
		
		$table = WL_DB_EscapeString($table);
		$rows_collection = array();
		$fields_collection = array();
		
		if (!empty($fields)) {
			foreach($fields as $field => $value) {
				$field = WL_DB_EscapeString($field);
				$value = WL_DB_EscapeString($value);
				
				if (is_string($value) && !empty($value)) $rows_collection[] = sprintf('\'%s\'', $value);
				if (is_integer($value)) $rows_collection[] = $value;
				if (is_null($value)) $rows_collection[] = 'NULL';
				if (is_string($value) && empty($value)) $rows_collection[] = 'NULL';
				
				$fields_collection[] = "`$field`";
			}
		}
		
		$q = 'INSERT INTO `' . WL_DB . "`.`$table` (" . implode(', ', $fields_collection) . ') VALUES (' . implode(', ', $rows_collection) . ')';

		if (!$echo) {
			WL_DB_QUERY($q);
		} else {
			echo $q;
		}
		return $sql -> insert_id;
	}
	
	function WL_DB_InsertMany($table, $fields) {
		$insert_values_per_field_collection = array();
		$insert_keys_per_field_collection = array();
		$insert_values_collection = '';
		$insert_keys_collection = '';
		$table = WL_DB_EscapeString($table);
		$insert_collection = array();
		
		if (!empty($fields)) {
			for ($i = 0; $i < count($fields); $i++) {
				$fields_collection_arr = $fields[$i];
				
				if (!empty($fields_collection_arr)) {
					foreach ($fields_collection_arr as $key => $value) {
						$value = WL_DB_EscapeString($value);
						$key = WL_DB_EscapeString($key);
						
						if (is_numeric($value)) {
							$insert_values_per_field_collection[] = "$value";
						} else {
							$insert_values_per_field_collection[] = "'$value'";
						}
						$insert_keys_per_field_collection[] = "`$table`.`$key`";
					}
					$insert_values_collection = implode(', ', $insert_values_per_field_collection);
					$insert_keys_collection = implode(', ', $insert_keys_per_field_collection);
					
					$insert_collection[] = '(' . $insert_values_collection . ')';
					
					$insert_values_per_field_collection = [];
					$insert_keys_per_field_collection = [];
				}
			}
			$q = 'INSERT INTO `' . WL_DB . "`.`$table` ($insert_keys_collection) VALUES " . implode(',', $insert_collection);
			WL_DB_QUERY($q);
		}
	}
	
	function WL_DB_FoundRows() {
		$ch = WL_DB_QUERY('SELECT FOUND_ROWS() AS `found`;');

		$result = array();
		$result = $ch -> fetch_assoc();
		$ch -> close();
		
		return (int)$result['found'];
	}
	
	function WL_DB_RowExists($table, $field, $value) {
		return WL_DB_GetField($table, $field, array([$field, '=', $value])) == $value;
	}
	
	function WL_DB_RowMatch($table, $fields) {
		return !empty(WL_DB_GetRow($table, '*', $fields)) ? true : false;
	}
	
	function WL_DB_AssocArray($table, $field, $value, $fields='*', $where='*', $callback=null, $summary_logic='AND', $order='', $group='', $offset=0, $count=0) {
		$result = array();
		
		$rows = WL_DB_GetRows($table, $fields, $where, null, 'AND', $order, $group, $offset, $count);
		foreach ($rows as $row) {
			$result[$row[$field]] = $row[$value];
		}
		
		return $result;
	}
	
	function WL_DB_GetArray($table, $field, $where='*', $summary_logic='AND', $order=null, $group=null, $offset=0, $count=0) {
		$result = array();
		//function WL_DB_GetRows($table, $fields='*', $where='*', $callback=null, $summary_logic='AND', $order='', $group='', $offset=0, $count=0) {
		$rows = WL_DB_GetRows($table, $field, $where, null, $summary_logic, $order, $group, $offset, $count);
		
		foreach ($rows as $row) {
			$result[] = $row[$field];
		}
		
		return $result;
	}
	
	function WL_DB_GetDelimitedList($table, $field, $delimiter=',', $where='*', $summary_logic='AND', $order=null, $group=null, $offset=0, $count=0) {
		return implode($delimiter, WL_DB_GetArray($table, $field, $where, $summary_logic, $order, $group, $offset, $count));
	}
?>