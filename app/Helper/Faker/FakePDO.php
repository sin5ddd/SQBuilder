<?php
	
	namespace sin5ddd\SQBuilder\Helper\Faker;
	
	use PDO;
	
	/**
	 * @deprecated
	 * !!! NEVER USE THIS IN PRODUCTION STAGE !!!
	 * This is Fake PDO Only for Test.
	 */
	class FakePDO extends PDO {
		protected string $sql;
		
		public function __construct(string $sql_file_path) {
			if (file_exists($sql_file_path)) {
				$this->sql = file_get_contents($sql_file_path);
			} else {
				$this->sql = 'hoge';
			}
		}
		
		public function exec(string $statement): false|int {
			if(str_contains($statement,'sale_estate_base')){
				return '';
			}
			if(str_contains($statement,'sale_estate_facility')){
				return '';
			}
			if(str_contains($statement,'sale_estate_desc')){
				return '';
			}
			if(str_contains($statement,'sale_estate_image')){
				return '';
			}
			return false;
		}
	}