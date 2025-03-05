<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use PHPUnit\Framework\TestCase;
	
	class BulkInsertTest extends TestCase {
		
		public function testBuild() {
			$bulk = new BulkInsert();
			$arr  = [
				[
					'firstName' => 'John',
					'lastName'  => 'Doe',
					'email'     => 'john@doe.com',
					'age'       => 22,
				],
				[
					'firstName' => 'Jane',
					'lastName'  => 'Doe',
					'email'     => 'jane@doe.com',
				],
				[
					'firstName' => 'JaneJane',
					'lastName'  => 'Doe',
					'email'     => 'janejane@doe.com',
					'age'       => 32,
				],
				[
					'firstName' => 'テスト',
					'email'     => 'test@taro.com',
				],
				[
					'firstName' => 'テスト',
					'lastName'  => '太郎',
					'email'     => 'hoge@taro.com',
				],
			];
			try {
				$bulk->setTableName('users')
				     ->acceptNull()
				     ->bulkAddPairs($arr)
				;
			} catch (\Exception $e) {
				self::fail($e->getMessage());
			}
			$ret = $bulk->build();
			self::assertIsString($ret);
			$bulk->buildToFile(__DIR__ . "/../sql/");
		}
	}
