<?php
	
	namespace sin5ddd\SQBuilder;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Keys\Where;
	use sin5ddd\SQBuilder\SQBuilder;
	use sin5ddd\SQBuilder\SQL_TYPE;
	
	class SQBuilderTest extends TestCase {
		
		public function test__construct() {
			$builder = SQBuilder::make(SQL_TYPE::INSERT);
			self::assertIsObject($builder);
		}
		
		public function test__select(){
			$builder = SQBuilder::make(SQL_TYPE::SELECT);
			$builder->select("id")
				->select("last_name")
				->select("first_name")
				->select("age")
				->select("email")
				->select("phone")
				->select("address")
				->select("city")
				->select("country")
				->select("postcode")
				->select("website")
				->select("created_at")
				->select("updated_at")
				->where(Where::equal("first_name", "John"))
				->where(Where::greaterEqual('age',20))
				->where(Where::between('wage',[2000,3000]))
				->where(Where::in("city",["New York","London","Los Angeles","Paris"]))
			;
			$builder->from("users");
			echo($builder->build()."\n");
			self::assertIsString($builder->build());
		}
	}
