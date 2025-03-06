<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\Builder\Alter;
	use sin5ddd\SQBuilder\Helper\Enum\METHOD;
	use sin5ddd\SQBuilder\Helper\Enum\DATA_TYPE;
	
	class AlterTest extends TestCase {
		
		public function testBuild() {
			// echo 'hoge';
			$alter = new Alter('user');
			$cmd = new AlterCmd(METHOD::ADD,'email2');
			$cmd->data_type(DATA_TYPE::VARCHAR)
				->size(255)
				->nullable(true)
				->after('email');
			$alter->addCommand($cmd);
			
			$cmd = new AlterCmd(METHOD::MODIFY,'email2');
			$cmd->data_type(DATA_TYPE::VARCHAR)
				->size(100)
				->nullable(true);
			$alter->addCommand($cmd);
			$str = $alter->build();
			self::assertIsString($str);
			$alter->buildToFile(__DIR__.'/../sql/');
		}
	}
