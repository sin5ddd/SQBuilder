<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use PDO;
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Helper\Enum\SQL_DB;
	use sin5ddd\SQBuilder\Helper\Faker\FakePDO;
	
	class ClassGeneratorTest extends TestCase {
		
		private function prepare_db(): void {
			$pdo = new PDO('mysql:host=localhost;dbname=database;', 'database_user', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
			$sqls = [
				'create_table_rent_build_base.sql',
				'sale_estate_base.sql',
				'sale_estate_desc.sql',
				'sale_estate_facility.sql',
				'sale_estate_image.sql',
				'create_view_some_table_joined.sql',
			];
			foreach ($sqls as $filename) {
				$path = __DIR__ . "/sample_sql/$filename";
				self::assertTrue(file_exists($path));
				$sql = file_get_contents($path);
				$pdo->exec($sql);
			}
		}
		
		public function test_parse_sql(): void {
			$this->prepare_db();
			if (!isset($this->pdo)) {
				$this->pdo = new PDO('mysql:host=localhost;dbname=database;', 'database_user', 'password');
			}
			$g = new TableObject(SQL_DB::MYSQL, $this->pdo);
			
			if (!file_exists(__DIR__ . '/dest/')) {
				mkdir(__DIR__ . '/dest/');
			}
			try {
				$g->setTableName('rent_build_base');
				$g->initFromPdo();
				$g->generate(__DIR__ . '/dest/', __NAMESPACE__);
				
				
				$g->setTableName('sale_estate_base');
				$g->initFromPdo();
				$g->generate(__DIR__ . '/dest/', __NAMESPACE__);
				
			} catch (\Exception $e) {
				echo $e->getMessage();
				die;
			}
		}
		
		
		public function test_view_generator(): void {
			$pdo = new PDO('mysql:host=localhost;dbname=database;', 'database_user', 'password');
			
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
			$path = __DIR__ . "/sample_sql/create_view_some_table_joined.sql";
			self::assertTrue(file_exists($path));
			$sql = file_get_contents($path);
			$pdo->exec($sql);
			
			$g = new ViewObject(SQL_DB::MYSQL, $pdo);
			$g->setTableName('estate_sale_all');
			$g->initFromPdo();
			$g->generate(__DIR__.'/dest/',__NAMESPACE__);
		}
		
		public function test_not_supported_type(): void {
			try {
				$g = new TableObject(SQL_DB::POSTGRESQL, new FakePDO(''));
			} catch (\Exception $e) {
				echo $e->getMessage() . PHP_EOL;
				self::assertInstanceOf(\Exception::class, $e);
			}
		}
	}
