<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\SQL_TYPE;
	use sin5ddd\SQBuilder\SQBuilder;
	use sin5ddd\SQBuilder\Keys\Where;
	
	class UpdateTest extends TestCase {
		
		public function testBuild() {
			/** @var Update $update */
			$update = SQBuilder::make(SQL_TYPE::UPDATE);
			$arr    =[
				'first_name'=>'Jane',
			];
			$update
				->addPairs($arr)
				->setTableName('users')
				->setCondition(Where::equal('id',1));
			$res = $update->build();
			self::assertEquals("UPDATE users SET first_name = 'Jane' WHERE id = 1", $res);
		}
	}
