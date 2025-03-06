<?php
	
	namespace sin5ddd\SQBuilder;
	
	use PDO;
	
	enum SQL_DB {
		case MYSQL;
		case MARIADB;
		case SQLSERVER;
		case POSTGRESQL;
	}
	
	/**
	 * テーブル定義からクラスを生成するジェネレーター
	 *
	 * @todo Mysql/MariaDB以外は現状未サポート
	 */
	class ObjGenerator {
		public string    $table_name;
		protected SQL_DB $db_type;
		protected string $orig_create_sql;
		public array     $columns;
		
		
		public function __construct(SQL_DB $db_type) {
			$this->db_type = $db_type;
		}
		
		public function genFromPdo(PDO $pdo, string $table_name): void {
			if ($this->db_type == SQL_DB::POSTGRESQL) {
				// todo postgres 動作未確認のためexit
				exit('not implemented');
				
			} else if ($this->db_type == SQL_DB::SQLSERVER) {
				// todo sqlserver 動作未確認のためexit
				exit('not implemented');
				
			}
		}
		
		public function genFromString(string $sql): void {
			$this->orig_create_sql = $sql;
		}
		
	
	}