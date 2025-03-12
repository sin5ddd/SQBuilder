<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	
	
	
	/**
	 * テーブル定義からクラスを生成するジェネレーター
	 *
	 * @todo Mysql系以外は現状未サポート
	 *       SQLViewへのUpsertは未対応
	 */
	class TableObject extends ISQLResultObject {

		public function initFromPdo(): void {
			$table_create_sql      = "SHOW CREATE TABLE $this->table_name;";
			// $ret                   = $this->pdo->exec($table_create_sql);
			$ret = $this->pdo->query($table_create_sql)->fetch();
			if(!$ret){
				throw new \PDOException('Creating Object from Table Failed');
			}
			$this->orig_create_sql = $ret['Create Table'];
		}
		
		
		protected function parse_sql(): void {
			// create sqlを解析する
			if (isset($this->orig_create_sql)) {
				if (str_starts_with($this->orig_create_sql, 'CREATE TABLE')) {
					// テーブルの場合
					$arr = [];
					preg_match('/CREATE TABLE `(.*)`/', $this->orig_create_sql, $arr);
					$this->table_name = $arr[1];
					$tmp_sql          = '';
					$pattern          = [
						'/CREATE TABLE.*[\n\r]/',
						'/\s\s\s*/',
						'/UNIQUE.*[\n\r]/',
						// '\`'
					];
					$rep              = [
						'',
						PHP_EOL,
						'',
						// ''
					];
					$tmp_sql          = preg_replace($pattern, $rep, "$this->orig_create_sql");
					$tmp_arr          = explode(PHP_EOL, $tmp_sql);
					foreach ($tmp_arr as $tmp) {
						if (str_starts_with($tmp, '`')) {
							$column = new Column();
							$column->setTypeFromCreateTable($tmp);
							$this->columns[] = $column;
						}
					}
				}
			} else {
				throw new \Exception("SQL not given");
			}
		}
		
		
	}
