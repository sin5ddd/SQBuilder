<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	class ViewObject extends ISQLResultObject {
		protected function parse_sql():void{
			// ビューの場合
			$tmp_arr = [];
			preg_match('/CREATE.*VIEW `(.*)`.*\n/', $this->orig_create_sql, $tmp_arr);
			if (sizeof($tmp_arr) == 0) {
				throw new \Exception('String does not seem to be a CREATE sql...');
			} else {
				$this->table_name = $tmp_arr[1]; // main table name
				
				$tables = [];
				preg_match_all('/.*`(.*)`\.`(.*)`\s*AS `(.*)`/', $this->orig_create_sql, $tmp_arr);
				// $tmp_arr[1] -> table alias, [2] -> column, [3] -> view column name
				for ($j = 0; $j < sizeof($tmp_arr[0]); $j++) {
					$c = new Column();
					$c->setTableName($tmp_arr[1][$j])
					  ->setName($tmp_arr[2][$j])
					  ->setAs($tmp_arr[3][$j])
					;
					
					$this->columns[$c->as] = $c;
				}
				
				// extracting joined table names
				preg_match_all('/JOIN `(.*)` `(.*)` ON/', $this->orig_create_sql, $tmp_arr);
				if (sizeof($tmp_arr) > 0) { // When found JOIN Clause
					// get and combine joined table names and aliases
					for ($i = 0; $i < sizeof($tmp_arr[0]); $i++) {
						$tables[$tmp_arr[2][$i]] = $tmp_arr[1][$i];
					}
					
					preg_match('/FROM.*`(.*)`.*`(.*)`/', $this->orig_create_sql, $tmp_arr);
					$tables[$tmp_arr[2]] = $tmp_arr[1];
				}
				
				foreach ($tables as $table_name => $table) {
					$t = new TableObject($table, $this->pdo);
					$t->initFromPdo();
				}
				
				// todo getting type of params from original table
				
				// todo make response
				var_dump($tables);
				// var_dump($this->columns);
				exit;
				
			}
		}
	}