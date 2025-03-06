<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	
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
	}