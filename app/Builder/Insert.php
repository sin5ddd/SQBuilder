<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class Insert extends IUpsert {
		
		
		public function build(): string {
			if (sizeof($this->values) == 0) {
				throw new Exception('upsert params are not specified yet');
			}
			if(!isset($this->table)){
				throw new Exception('into param needed');
			}
			$insert_fields = implode(', ', array_keys($this->values));
			$insert_values = implode(', ', EscapeValues::check_str(array_values($this->values)));
			
			$ret = "INSERT INTO $this->table ($insert_fields) VALUES ($insert_values)";
			
			return $ret;
		}
		
	}