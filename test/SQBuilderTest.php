<?php
	
	namespace sin5ddd\SQBuilder;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Keys\Func;
	use sin5ddd\SQBuilder\Keys\Where;
	
	class SQBuilderTest extends TestCase {
		
		public function test__construct() {
			$builder = SQBuilder::make(SQL_TYPE::INSERT);
			self::assertIsObject($builder);
		}
		
		public function test__select() {
			$builder = SQBuilder::make(SQL_TYPE::SELECT);
			$builder
				->select("id")
				->join("images", "id", "user_id", 'img')
				->join("pages", "id", "user_id")
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
				->select(Func::count("img.id", "image_count"))
				->select(Func::avg("pages.view", "avg_pv"))
				->where(Where::equal("first_name", "John"))
				->where(Where::greaterEqual('age', 20))
				->where(Where::between('wage', [2000, 3000,]))
				->where(Where::in("city", ["New York", "London", "Los Angeles", "Paris",]))
			;
			$builder->from("users");
			echo($builder->build() . "\n");
			self::assertIsString($builder->build());
		}
	}
