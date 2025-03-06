<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class Upsert extends IUpsert {
		private ?string $on_update = null;
		
		public function __construct() {
			$this->method = "upsert";
		}
		public function key(string $key): Upsert {
			$this->key = $key;
			return $this;
		}
		
		public function build(): string {
			if (sizeof($this->pairs) == 0) {
				throw new Exception('upsert params are not specified yet');
			}
			if (!isset($this->table_name)) {
				throw new Exception('into param needed');
			}
			if ($this->on_update == null) {
				$set_arr = [];
				foreach ($this->pairs as $k => $v) {
					if($k != $this->key) {
						$set_arr[] = "$k = " . EscapeValues::check_str($v);
					}
				}
				$this->on_update = implode(", ", $set_arr);
			}
			$insert_fields = implode(', ', array_keys($this->pairs));
			$insert_values = implode(', ', EscapeValues::check_str(array_values($this->pairs)));
			
			$ret = "INSERT INTO $this->table_name ($insert_fields) VALUES ($insert_values)";
			$ret .= " ON DUPLICATE KEY UPDATE $this->on_update";
			return $ret;
		}
		
		public function setOnUpdate(string $on_update): Upsert {
			$this->on_update = $on_update;
			return $this;
		}
		
	}