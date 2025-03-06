<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator;
	
	use PHPUnit\Framework\TestCase;
	
	class ClassGeneratorTest extends TestCase {
		public function test_parse_sql(): void {
			$g = new ClassGenerator(SQL_DB::MYSQL);
			$path = __DIR__ . '/create_table_rent_build_base.sql';
			self::assertTrue(file_exists($path));
			$sql = file_get_contents($path);
			$g->initFromString($sql);
			$g->generate(__DIR__.'/');
		}
		
		public function test_not_supported_type(): void {
			try {
				$g = new ClassGenerator(SQL_DB::POSTGRESQL);
			}catch (\Exception $e) {
				echo $e->getMessage().PHP_EOL;
				self::assertInstanceOf(\Exception::class, $e);
			}
		}
	}
