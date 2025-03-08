<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Helper\Enum\SQL_DB;
	use sin5ddd\SQBuilder\Helper\Faker\FakePDO;
	
	class ClassGeneratorTest extends TestCase {
		public function test_parse_sql(): void {
			$path = __DIR__ . '/create_table_rent_build_base.sql';
			$g = new TableObject(SQL_DB::MYSQL, new FakePDO($path));
			self::assertTrue(file_exists($path));
			$sql = file_get_contents($path);
			$g->initFromString($sql);
			$g->generate(__DIR__.'/',__NAMESPACE__);
		}
		
		
		
		public function test_not_supported_type(): void {
			try {
				$g = new TableObject(SQL_DB::POSTGRESQL, new FakePDO(''));
			}catch (\Exception $e) {
				echo $e->getMessage().PHP_EOL;
				self::assertInstanceOf(\Exception::class, $e);
			}
		}
	}
