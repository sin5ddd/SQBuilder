<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class Insert extends IUpsert {
		public function __construct() { $this->method = "insert"; }
		
		public function build(): string {
			if (sizeof($this->pairs) == 0) {
				throw new Exception('upsert params are not specified yet');
			}
			if(!isset($this->table_name)){
				throw new Exception('into param needed');
			}
			$insert_fields = implode(', ', array_keys($this->pairs));
			$insert_values = implode(', ', EscapeValues::check_str(array_values($this->pairs)));
			
			$ret = "INSERT INTO $this->table_name ($insert_fields) VALUES ($insert_values)";
			
			return $ret;
		}
	}