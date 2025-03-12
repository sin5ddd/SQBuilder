<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use sin5ddd\SQBuilder\Helper\Enum\PHP_TYPE;
	
	class Column {
		public string $table_name;
		public string $name;
		public string $as;
		public string $type;
		
		public function setTableName(string $table_name): Column {
			$this->table_name = $table_name;
			return $this;
		}
		
		public function setName(string $name): Column {
			$this->name = $name;
			return $this;
		}
		
		public function setAs(string $as): Column {
			$this->as = $as;
			return $this;
		}
		
		public function setType(string $type): Column {
			$this->type = $type;
			return $this;
		}
		
		/**
		 *
		 * @param string $sql A single line from CREATE TABLE format
		 *
		 * @return void
		 */
		public function setTypeFromCreateTable(string $sql): void {
			$nullable = !str_contains($sql, 'NOT NULL')
				? '?'
				: '';
			
			$cl = explode(' ', $sql);
			
			// var_dump($cl);
			// カラム名取得
			$this->name = str_replace('`', '', $cl[0]);
			// 型の判定
			$this->setType($nullable.$this->convertSQLType($cl[1]));
		}
		
		public function setTypeFromSQLType(string $type): void {
			$this->type = $this->convertSQLType($type);
		}
		
		
		private function convertSQLType(string $type): string {
			if (str_contains($type, 'double') || str_contains($type, 'float')) {
				return PHP_TYPE::FLOAT->value;
			} else if (str_contains($type, 'tinyint(1)')) {
				// MySQL以外の環境だと違うかも
				return PHP_TYPE::BOOL->value;
			} else if (str_contains($type, 'int')) {
				return PHP_TYPE::INT->value;
			} else if (str_contains($type, 'decimal')) {
				return PHP_TYPE::INT->value;
			} else if (str_contains($type, 'varchar') || str_contains($type, 'text')) {
				return PHP_TYPE::STRING->value;
			} else if (str_contains($type, 'date')) {
				return PHP_TYPE::DATETIME->value;
			} else if (str_contains($type, 'timestamp')) {
				return PHP_TYPE::DATETIME->value;
			} else {
				throw new \Exception('Unknown column type:' . $type);
			}
		}
	}