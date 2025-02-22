<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	
	abstract class IBuilder {
		private array  $params = [];
		protected string $from   = '';
		private array  $order  = [];
		protected string $method;
		private array  $set    = [];
		private array  $fields = [];
		private array  $values = [];
		private string $key;
		private string $key_value;
		private array  $join   = [];
		private array  $group  = [];
		private int    $limit  = 0;
		private string $order_direction;
		
		
		
		private function parse(array $arguments): array {
			$params = [];
			foreach ($arguments as $arg) {
				if (is_array($arg)) {
					$params[] = implode(',', $this->parse($arg));
				} else if (is_object($arg) && get_class($arg) === get_class($this)) {
					$params[] = sprintf('(%s)', $arg->build());
				} else {
					$params[] = $arg;
				}
			}
			return $params;
		}
		
		public function __call($name, $arguments) {
			if (strtolower($name) == 'and') {
				$this->where[] = implode(' ', $arguments);
			} else {
				$this->params = array_merge(
					$this->params, $this->parse(array_merge(array_map('strtoupper', explode('_', $name)), $arguments)));
			}
			return $this;
		}
		
		public function order_direction(string $direction): self {
			$this->order_direction = $direction;
			return $this;
		}
		
		public function order(?string $order_column, int $direction = 0): self {
			if (!empty($order_column)) {
				if ($direction > 0) {
					$dir = ' ASC';
				} else {
					$dir = ' DESC';
				}
				$this->order[] = $order_column . $dir;
			}
			return $this;
		}
		
		public function group(?string $group_column): self {
			if (!empty($group_column)) {
				$this->group[] = $group_column;
			}
			return $this;
		}
		
		
		/**
		 * SQL文書き出し
		 *
		 * @return string
		 * @throws Exception
		 */
		abstract public function build(): string;
		public function build_old():string{
			$ret = 'not implemented for ' . $this->method;
			
			$update_values_arr = [];
			for ($i = 0; $i < sizeof($this->fields); $i++) {
				$update_values_arr[] = "{$this->fields[$i]} = {$this->values[$i]}";
			}
			$update_values = implode(', ', $update_values_arr);
			
			if ($this->method == 'update') { // todo 別クラス化
				$ret = "UPDATE " . $this->from . ' SET ';
				$ret .= $update_values;
				$ret .= " WHERE " . implode(' AND ', $this->where);
			} else if ($this->method === 'upsert') { // todo 別クラス化
				if (sizeof($this->fields) < 1 || sizeof($this->values) < 1
				    || empty($this->key) || empty($this->key_value)) {
					throw new Exception('upsert params are not specified yet');
				}
				$insert_fields = implode(', ', $this->fields);
				$insert_values = implode(', ', $this->values);
				
				
				$ret = "INSERT INTO $this->from ($this->key, $insert_fields)";
				$ret .= " VALUES ($this->key_value,$insert_values)";
				$ret .= "ON DUPLICATE KEY UPDATE $update_values";
				
			}
			// todo BulkInsert別クラスで実装
			// todo BulkUpdate別クラスで実装
			return $ret;
		}
		
		
		public function update(string $arg): self {
			$this->set_method('update');
			$this->from = $arg;
			return $this;
		}
		
		private function set_method(string $method) {
			if (empty($this->method)) {
				$this->method = $method;
			} else {
				throw new Exception('method has been chosen already:' . $this->method);
			}
		}
		
		public function upsert(string $arg): self {
			$this->set_method('upsert');
			$this->from = $arg;
			return $this;
		}
		
		public function key(string $key, string $value): self {
			if ($this->method !== 'upsert') {
				throw new Exception('key() must be called with upsert method');
			}
			$this->key       = $key;
			$this->key_value = $value;
			return $this;
		}
		
		public function set(string $arg1, string|int|float $arg2): self {
			if (gettype($arg2) == 'string') {
				$arg2 = $this->pdo->quote($arg2);
			}
			$this->fields[] = $arg1;
			$this->values[] = $arg2;
			return $this;
		}
		

		
}