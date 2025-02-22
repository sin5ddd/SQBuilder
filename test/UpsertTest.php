<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\SQL_TYPE;
	use sin5ddd\SQBuilder\SQBuilder;
	
	class UpsertTest extends TestCase {
		
		public function testBuild() {
			$upsert = new Upsert();
			$arr    = [
				'first_name' => 'John',
				'last_name'  => 'Doe',
				'email'      => 'johndoe@example.com',
			];
			$res = $upsert->setTable('users')
				->addPairs($arr)
				->build();
			self::assertIsString($res);
			self::assertEquals("INSERT INTO users (first_name, last_name, email) VALUES ('John', 'Doe', 'johndoe@example.com') ON DUPLICATE KEY UPDATE first_name = 'John', last_name = 'Doe', email = 'johndoe@example.com'", $res);
		}
	}
