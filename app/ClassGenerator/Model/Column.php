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
		public function setFromSQL(string $sql): void {
			$nullable = !str_contains($sql, 'NOT NULL')
				? '?'
				: '';
			
			$cl       = explode(' ', $sql);
			
			// var_dump($cl);
			// カラム名取得
			$this->name = str_replace('`', '', $cl[0]);
			// 型の判定
			if (str_contains($cl[1], 'double') || str_contains($cl[1], 'float')) {
				$this->setType($nullable . PHP_TYPE::FLOAT->value);
			} else if (str_contains($cl[1], 'tinyint(1)')) {
				// MySQL以外の環境だと違うかも
				$this->type = $nullable . PHP_TYPE::BOOL->value;
			} else if (str_contains($cl[1], 'int')) {
				$this->type = $nullable . PHP_TYPE::INT->value;
			} else if (str_contains($cl[1], 'varchar') || str_contains($cl[1], 'text')) {
				$this->type = $nullable . PHP_TYPE::STRING->value;
			} else if (str_contains($cl[1], 'date')) {
				$this->type = $nullable . PHP_TYPE::DATETIME->value;
			}
		}
	}