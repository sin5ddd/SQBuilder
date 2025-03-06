<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	function camelize(string $s): string {
		return str_replace([
			                   ' ',
			                   '-',
			                   '_',
		                   ], '', ucwords($s, ' -_'));
	}
	enum SQL_DB {
		case MYSQL;
		case MARIADB;
		case SQLSERVER;
		case POSTGRESQL;
	}
	
	enum PHP_TYPE: string {
		case FLOAT = 'float';
		case INT = 'int';
		case STRING = 'string';
		case BOOL = 'bool';
		case ARRAY = 'array';
		case OBJECT = 'object';
		case DATETIME = '\DateTimeImmutable';
	}
	
	/**
	 * テーブル定義からクラスを生成するジェネレーター
	 *
	 * @todo Mysql系以外は現状未サポート
	 */
	class ClassGenerator {
		public bool      $a;
		protected SQL_DB $db_type;
		protected string $table_name;
		/**
		 * @var array<Column>
		 */
		protected array  $columns;
		protected string $orig_create_sql;
		
		public function __construct(SQL_DB $db_type) {
			if($db_type !== SQL_DB::MYSQL){
				throw new \Exception("Sorry, ".$db_type->name . " does not support yet");
			}
			$this->db_type = $db_type;
		}
		
		public function initFromPdo(\PDO $pdo, string $table_name): void {
			$table_create_sql      = "SHOW CREATE TABLE $table_name;";
			$ret                   = $pdo->exec($table_create_sql);
			$this->orig_create_sql = $ret['Create Table'];
		}
		
		public function initFromString(string $sql): void {
			$this->orig_create_sql = $sql;
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
						$nullable = str_contains($tmp, 'NOT NULL')?"":"?";
						$cl       = explode(' ', $tmp);
						if (str_starts_with($cl[0], '`')) {
							var_dump($cl);
							$column = new Column();
							// var_dump($cl);
							// カラム名取得
							$column->setName(str_replace('`', '', $cl[0]));
							// 型の判定
							if (str_contains($cl[1], 'double') || str_contains($cl[1], 'float')) {
								$column->setType($nullable.PHP_TYPE::FLOAT->value);
							} else if (str_contains($cl[1], 'tinyint(1)')) {
								// MySQL以外の環境だと違うかも
								$column->setType($nullable.PHP_TYPE::BOOL->value);
							} else if (str_contains($cl[1], 'int')) {
								$column->setType($nullable.PHP_TYPE::INT->value);
							} else if (str_contains($cl[1], 'varchar') || str_contains($cl[1], 'text')) {
								$column->setType($nullable.PHP_TYPE::STRING->value);
							} else if (str_contains($cl[1], 'date')) {
								$column->setType($nullable.PHP_TYPE::DATETIME->value);
							}
							$this->columns[] = $column;
							
						}
					}
				}
				if (str_contains($this->orig_create_sql, 'VIEW `')) {
					// ビューの場合
					// todo:テーブルエイリアスを取得する
				}
				
			} else {
				throw new \Exception("SQL not given");
			}
		}
		
		public function generate(string $path): void {
			$this->parse_sql();
			
			// todo クラスファイルを生成する
			$php_str = '<?php' . PHP_EOL;
			$php_str .= '/** ' . PHP_EOL;
			$php_str .= ' * Generated with sin5ddd/SQBuilder' . PHP_EOL;
			$php_str .= ' */' . PHP_EOL;
			$php_str .= 'class '.camelize($this->table_name).' {' . PHP_EOL;
			foreach ($this->columns as $c) {
				$php_str .= "    public $c->type \$$c->name;". PHP_EOL;
			}
			$php_str .= '}' . PHP_EOL;
			
			file_put_contents($path.camelize($this->table_name).".php", $php_str);
		}
		

	}
