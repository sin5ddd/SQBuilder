<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use sin5ddd\SQBuilder\Builder\BulkInsert;
	
	class BulkUpdate extends BulkInsert {
		protected array $keys;
		
		public function __construct() { $this->method = "bulk_update"; }
		
		public function build(): string {
			$update_state = [];
			for ($i = 0; $i < sizeof($this->columns); $i++) {
				$col = $this->columns[$i];
				if (array_key_exists($col,$this->keys)) {
					$update_state[] = "$col = new.$col";
				}
			}
			$ret = parent::build();
			$ret .= " AS new ON DUPLICATE KEY UPDATE " . implode(', ', $update_state);
			return $ret;
		}
		
		/**
		 * キーに指定されているカラムはUPDATE対象外にする
		 * @param string $key
		 *
		 * @return $this
		 */
		public function addKey(string $key): BulkUpdate {
			$this->key[] = $key;
			return $this;
		}
	}