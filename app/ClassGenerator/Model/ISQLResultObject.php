<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use PDO;
	use sin5ddd\SQBuilder\Helper\Enum\SQL_DB;

	class ISQLResultObject {
		protected SQL_DB $db_type;
		protected string $table_name;
		/**
		 * @var array<Column>
		 */
		protected array  $columns;
		protected string $orig_create_sql;
		
		protected PDO $pdo;
		
		public function __construct(SQL_DB $db_type, ?PDO $pdo = null) {
			if ($db_type !== SQL_DB::MYSQL) {
				throw new \Exception('Sorry, ' . $db_type->name . ' does not support yet');
			}
			$this->db_type = $db_type;
			$this->pdo     = $pdo;
		}
		
		public function initFromString(string $sql): void {
			$this->orig_create_sql = $sql;
		}
		function camelize(string $s): string {
			return str_replace([
				                   ' ',
				                   '-',
				                   '_',
			                   ], '', ucwords($s, ' -_'));
		}
		
		public function generate(string $path, ?string $namespace=null): void {
			$this->parse_sql();
			
			// クラスファイルを生成する
			$php_str = '<?php' . PHP_EOL;
			$php_str .= '/** ' . PHP_EOL;
			$php_str .= ' * Generated with sin5ddd/SQBuilder' . PHP_EOL;
			$php_str .= ' */' . PHP_EOL;
			if($namespace){
				$php_str .= 'namespace ' . $namespace . ';' . PHP_EOL;
			}
			$php_str .= 'class ' . $this->camelize($this->table_name) . ' {' . PHP_EOL;
			foreach ($this->columns as $c) {
				$php_str .= "    public $c->type \$$c->name;" . PHP_EOL;
			}
			$php_str .= '}' . PHP_EOL;
			
			file_put_contents($path . $this->camelize($this->table_name) . '.php', $php_str);
		}
		
		public function setTableName(string $table_name): void {
			$this->table_name = $table_name;
		}
		
	}