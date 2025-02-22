<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	
	class IBuilder {
		private array  $params = [];
		private array  $where  = [];
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
		 * @param string|null $arg
		 *
		 * @return SQBuilder
		 */
		// public function where(?string $arg): self {
		// 	if (!empty($arg)) {
		// 		array_push($this->where, $arg);
		// 	}
		// 	return $this;
		// }
		
		/**
		 * SQL文書き出し
		 *
		 * @return string
		 * @throws Exception
		 */
		public function build(): string {
			$ret = 'not implemented for ' . $this->method;
			if (empty($this->select)) {
				//				throw new Exception("QueryBuilder: no SELECT field specified.");
			}
			if (empty($this->from)) {
				//				throw new Exception("QueryBuilder: no FROM table specified.");
			}
			
			$update_values_arr = [];
			for ($i = 0; $i < sizeof($this->fields); $i++) {
				$update_values_arr[] = "{$this->fields[$i]} = {$this->values[$i]}";
			}
			$update_values = implode(', ', $update_values_arr);
			// Generate SELECT
			if ($this->method == 'select') {
				$ret = "SELECT ";
				$ret .= implode(', ', $this->select);
				$ret .= " FROM {$this->from}";
				if (!empty($this->join)) {
					$ret .= ' ' . implode(' ', $this->join);
				}
				if (!empty($this->where)) {
					// Generate WHERE
					$ret .= " WHERE ";
					$ret .= implode(' AND ', $this->where);
				}
				if (!empty($this->group)) {
					// Generate GROUP
					$ret .= " GROUP BY ";
					$ret .= implode(', ', $this->group);
				}
				if (!empty($this->order)) {
					// Generate ORDER
					$ret .= " ORDER BY ";
					$ret .= implode(', ', $this->order);
				}
				if ($this->limit > 0) {
					$ret .= " LIMIT $this->limit";
				}
			} else if ($this->method == 'update') {
				$ret = "UPDATE " . $this->from . ' SET ';
				$ret .= $update_values;
				$ret .= " WHERE " . implode(' AND ', $this->where);
			} else if ($this->method === 'upsert') {
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
			return $ret;
		}
		
		/**
		 * @param string|array $args
		 *
		 * @return IBuilder
		 */
		public function select(string|array $args): self {
			if (!empty($this->method) && $this->method != 'select') {
				throw new Exception('method has been chosen already:' . $this->method);
			}
			$this->method = 'select';
			// $arg_list     = explode(',', str_replace(' ', '', $arg));
			if (gettype($args) === "array") {
				$arg_list = $args;
			} else {
				$arg_list = explode(',', str_replace('  ', ' ', $args));
			}
			foreach ($arg_list as $v) {
				$this->select[] = $v;
			}
			return $this;
		}
		
		public function select_long(string $arg): self {
			if (!empty($this->method) && $this->method != 'select') {
				throw new Exception('method has been chosen already:' . $this->method);
			}
			$this->method = 'select';
			array_push($this->select, $arg);
			return $this;
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
		
		/**
		 * @throws Exception
		 */
		public function join(string $table_name, string $master_key, string $table_key = '', string $append_cond = ''): self {
			if ($this->method !== 'select') {
				// SELECT文以外では例外
				throw new Exception('Join must be called in SELECT method.');
			}
			if ($table_key === '') {
				if (str_contains($master_key, '.')) {
					$tmp_arr   = explode('.', $master_key);
					$table_key = $tmp_arr[1];
				} else {
					$table_key = $master_key;
				}
			}
			$join_state = "LEFT JOIN $table_name ON $master_key = $table_name.$table_key";
			if ($append_cond !== '') {
				$join_state .= " AND $append_cond";
			}
			if ($join_state !== '') {
				$this->join[] = $join_state;
			}
			return $this;
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