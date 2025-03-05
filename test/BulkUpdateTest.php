<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use PHPUnit\Framework\TestCase;
	
	class BulkUpdateTest extends TestCase {
		
		public function testBuild() {
			$bulk = new BulkUpdate();
			$arr  = [
				[
					'id'        => 1,
					'firstName' => 'John',
					'lastName'  => 'Doe',
					'email'     => 'john@doe.com',
				],
				[
					'id'        => 2,
					'firstName' => 'Jane',
					'lastName'  => 'Doe',
					'email'     => 'jane@doe.com',
				],
				[
					'id'        => 3,
					'firstName' => 'JaneJane',
					'lastName'  => 'Doe',
					'email'     => 'janejane@doe.com',
				],
				[
					'id'        => 4,
					'firstName' => 'テスト',
					'lastName'  => '太郎',
					'email'     => 'test@taro.com',
				],
				[
					'id'    => 5,
					'email' => 'hoge@taro.com',
				],
			];
			$bulk->setTableName('users')
			     ->addKey('id')
			     ->acceptNull()
			     ->bulkAddPairs($arr)
			;
			$ret = $bulk->build();
			
			self::assertIsString($ret);
			
			$bulk->buildToFile(__DIR__.'/../sql/');
		}
	}
