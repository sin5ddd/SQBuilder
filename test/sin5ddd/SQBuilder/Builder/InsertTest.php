<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use PHPUnit\Framework\TestCase;
	
	class InsertTest extends TestCase {
		
		public function testAddPairs() {
			$insert = new Insert();
			self::assertIsObject($insert);
			$arr    = [
				'first_name' => 'John',
				'last_name'  => 'Doe',
				'age'        => 22,
				'wage'       => 2800,
				'height'     => 182,
				'address'    => 'Birmingham',
				'city'       => 'London',
				'state'      => 'London',
				'zip'        => '10293',
				'country'    => 'England',
			];
			self::assertIsObject($insert->setTableName('users')
			       ->addPairs($arr));
			
			$ret = $insert->build();
			$insert->buildToFile(__DIR__."/../sql/");
			self::assertIsString($ret);
		}
		
	}
