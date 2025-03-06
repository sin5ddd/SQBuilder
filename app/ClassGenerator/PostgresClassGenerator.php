<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	
	class PostgresClassGenerator extends ClassGenerator {
		
		/**
		 * 未テスト
		 * @param \PDO   $pdo
		 * @param string $table_name
		 *
		 * @return void
		 */
		public function initFromPdo(\PDO $pdo, string $table_name): void {
			$db_name = 'db_name';
			$db_user = 'db_user';
			
			$this->orig_create_sql =
				exec("pg_dump $db_name -U $db_user -s -t $table_name");
		}
	}