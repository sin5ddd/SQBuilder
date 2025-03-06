<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	
	class SQLServerClassGenerator extends ClassGenerator {
		/**
		 * 未テスト
		 * @param \PDO   $pdo
		 * @param string $table_name
		 *
		 * @return void
		 */
		public function initFromPdo(\PDO $pdo, string $table_name): void {
			$table_create_sql = "EXEC sp_columns @tale_name = $table_name;";
			// 縦持ちのクエリ結果として返ってくる（配列）ので抽出
			$ret                   = $pdo->exec($table_create_sql);
			$this->orig_create_sql = "CREATE TABLE `$table_name` (";
			$tmp_arr               = [];
			for ($i = 0; $i < sizeof($ret); $i++) {
				$c_name     = $ret[$i]['COLUMN_NAME'];
				$c_type     = $ret[$i]['TYPE_NAME'];
				$c_nullable = $ret[$i]['NULLABLE'];
				$tmp_arr[]  = "`$c_name` $c_type $c_nullable";
			}
			$this->orig_create_sql .= implode(",", $tmp_arr) . ')';
		}
		
	}