<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use sin5ddd\SQBuilder\Helper\Enum\SQL_DB;
	use sin5ddd\SQBuilder\Helper\Enum\DATA_TYPE;
	
	class ViewObject extends ISQLResultObject {
		protected function parse_sql(): void {
			// ビューの場合
			$tmp_arr = [];
			preg_match('/CREATE.*VIEW `([a-zA-Z0-9_]*)` AS/', $this->orig_create_sql, $tmp_arr);
			if (sizeof($tmp_arr) == 0) {
				throw new \Exception('String does not seem to be a CREATE sql...');
			} else {
				$this->table_name = $tmp_arr[1]; // main table name
				
				$tables = [];
				preg_match_all('/`([a-zA-Z0-9_]*)`\.`([a-zA-Z0-9_]*)` AS `([a-zA-Z0-9_]*)`,/', $this->orig_create_sql, $tmp_arr);
				// $tmp_arr[1] -> table alias, [2] -> column, [3] -> view column name
				for ($j = 0; $j < sizeof($tmp_arr[0]); $j++) {
					$c = new Column();
					$c
						->setName($tmp_arr[2][$j])
						->setAs($tmp_arr[3][$j])
					;
					
					$this->columns[$c->name] = $c;
				}
				
				// extracting joined table names
				preg_match_all('/join `([a-zA-Z0-9_]*)`\s`([a-zA-Z0-9_]*)`\son/', $this->orig_create_sql, $tmp_arr);
				if (sizeof($tmp_arr) > 0) { // When found JOIN Clause
					// get and combine joined table names and aliases
					for ($i = 0; $i < sizeof($tmp_arr[0]); $i++) {
						$tables[$tmp_arr[2][$i]] = $tmp_arr[1][$i];
					}
					
					preg_match('/from \(*`(.[a-zA-Z0-9_]*)` `([a-zA-Z0-9_]*)`/', $this->orig_create_sql, $tmp_arr);
					$tables[$tmp_arr[2]] = $tmp_arr[1];
				}
				
				foreach ($tables as $table_alias => $table_name) {
					if($table_name) {
						// getting type of params from original table
						$sql         = "SHOW COLUMNS FROM `$table_name`";
						$arr         = $this->pdo->query($sql)
						                         ->fetchAll()
						;
						$field_types = [];
						foreach ($arr as $a) {
							$field_types[$a['Field']] = $a['Type'];
						}
						foreach ($field_types as $field => $type) {
							if(array_key_exists($field, $this->columns)) {
								$this->columns[$field]->setTableName($table_name);
								$this->columns[$field]->setTypeFromSQLType($type);
							}
						}
					}
				}
			}
		}
		
		public function initFromPdo(): void {
			$table_create_sql = "SHOW CREATE VIEW $this->table_name;";
			
			$ret = $this->pdo->query($table_create_sql)
			                 ->fetch()
			;
			if (!$ret) {
				throw new \PDOException('Creating Object from Table Failed');
			}
			$this->orig_create_sql = $ret['Create View'];
		}
	}