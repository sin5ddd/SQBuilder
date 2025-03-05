<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class Update extends IUpsert {
		protected string $condition;
		
		public function __construct() { $this->method = "update"; }
		
		public function setCondition(string $condition): Update {
			$this->condition = $condition;
			return $this;
		}
		
		
		public function build(): string {
			if(!$this->table_name){
				throw new Exception("table must be set");
			}
			if(sizeof($this->pairs) == 0){
				throw new Exception("empty values");
			}
			if(!$this->condition){
				throw new Exception("this method does not gen whole UPDATE SQL");
			}
			$set_arr = [];
			foreach ($this->pairs as $k=> $v) {
				$set_arr[] = "$k = ".EscapeValues::check_str($v);
			}
			$set_string = implode(", ", $set_arr);
			$ret = "UPDATE $this->table_name SET $set_string WHERE $this->condition";
			return $ret;
		}
		
	}