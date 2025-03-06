<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	
	use sin5ddd\SQBuilder\ClassGenerator\ClassGenerator;
	
	class MySQLClassGenerator extends ClassGenerator {
		
		public function initFromPdo(\PDO $pdo, string $table_name): void {
			$table_create_sql      = "SHOW CREATE TABLE $table_name;";
			$ret                   = $pdo->exec($table_create_sql);
			$this->orig_create_sql = $ret['Create Table'];
		}
	}