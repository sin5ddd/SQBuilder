<?php
	
	namespace sin5ddd\SQBuilder\ClassGenerator\Model;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Helper\Enum\SQL_DB;
	use sin5ddd\SQBuilder\Helper\Faker\FakePDO;
	
	class ViewObjectTest extends TestCase {
		public function test_create_class_from_view():void{
			$path = __DIR__ . '/create_view_some_table_joined.sql';
			$g = new ViewObject(SQL_DB::MYSQL, new FakePDO($path));
			self::assertTrue(file_exists($path));
			$sql = file_get_contents($path);
			$g->initFromString($sql);
			$g->generate(__DIR__.'/');
		}
	}
