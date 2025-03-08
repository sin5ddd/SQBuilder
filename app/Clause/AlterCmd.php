<?php
	
	namespace sin5ddd\SQBuilder\Clause;
	
	
	use sin5ddd\SQBuilder\Helper\Enum\METHOD;
	use sin5ddd\SQBuilder\Helper\Enum\DATA_TYPE;
	
	class AlterCmd {
		protected METHOD $method;
		protected string $column_name;
		public DATA_TYPE $data_type;
		public int       $size;
		public bool      $auto_increment = false;
		public bool      $nullable       = false;
		public ?string   $default_value  = null;
		public ?string   $on_update      = null;
		public ?string   $after          = null;
		
		/**
		 * @param METHOD $method
		 * @param string $column_name
		 */
		public function __construct(METHOD $method, string $column_name) {
			$this->column_name = $column_name;
			$this->method      = $method;
		}
		
		/**
		 * Bulk set with array
		 *
		 * @param $array [
		 *               'data_type' => DATA_TYPE,
		 *               'size' => int,
		 *               'auto_increment' => bool,
		 *               'nullable' => bool,
		 *               'default_value' => string,
		 *               'on_update' => string
		 *               ]
		 *
		 * @return void
		 * @throws \Exception
		 */
		public function setWithArray($array): void {
			if (array_key_exists('data_type', $array)) {
				$d= $array['data_type'];
				if(get_class($d) !== DATA_TYPE::class) {
					throw new \Exception("Data type must be " . DATA_TYPE::class);
				}
				$this->data_type = $d;
			}
			if (array_key_exists('size', $array)) {
				$this->size = intval($array['size']);
			}
			if (array_key_exists('auto_increment', $array)) {
				$this->auto_increment = boolval($array['auto_increment']);
			}
			if (array_key_exists('nullable', $array)) {
				$this->nullable = boolval($array['nullable']);
			}
			if (array_key_exists('default_value', $array)) {
				$this->default_value = $array['default_value'];
			}
			if (array_key_exists('on_update', $array)) {
				$this->on_update = $array['on_update'];
			}
		}
		
		/**
		 * returns formatted SQL sentences
		 *
		 * @return string
		 */
		public function bake(): string {
			$ret = $this->method->value;
			$ret .= $this->column_name;
			if ($this->method == METHOD::DROP) {
				return $ret;
			}
			$ret .= " ";
			if ($this->data_type == DATA_TYPE::VARCHAR && isset($this->size)) {
				$ret .= $this->data_type->value . "($this->size)";
			} else {
				$ret .= $this->data_type->value;
			}
			$ret .= $this->auto_increment
				? " AUTO_INCREMENT"
				: "";
			$ret .= $this->nullable
				? " NULL"
				: " NOT NULL";
			$ret .= isset($this->default_value)
				? " DEFAULT " . $this->default_value
				: "";
			$ret .= isset($this->on_update)
				? " ON UPDATE '" . $this->on_update . "'"
				: "";
			$ret .= isset($this->after)
				? " AFTER " . $this->after
				: "";
			
			return $ret;
		}
		
		/**
		 * Set column data type (like VARCHAR or TEXT)
		 * @param DATA_TYPE $data_type
		 *
		 * @return $this
		 */
		public function data_type(DATA_TYPE $data_type): AlterCmd {
			$this->data_type = $data_type;
			return $this;
		}
		
		/**
		 * Set column data size like VARCHAR(255)
		 * Not necessary for some data type
		 * @param int $size
		 *
		 * @return $this
		 */
		public function size(int $size): AlterCmd {
			$this->size = $size;
			return $this;
		}
		
		/**
		 * Set column AUTO_INCREMENT flag
		 * @param bool $auto_increment
		 *
		 * @return $this
		 */
		public function auto_increment(bool $auto_increment): AlterCmd {
			$this->auto_increment = $auto_increment;
			return $this;
		}
		
		/**
		 * Set column Nullable or not
		 * default value: false -> NOT NULL
		 * @param bool $nullable
		 *
		 * @return $this
		 */
		public function nullable(bool $nullable): AlterCmd {
			$this->nullable = $nullable;
			return $this;
		}
		
		/**
		 * Set column's DEFAULT_VALUE value in string
		 * You can use SQL Functions like 'TIMESTAMP()'
		 * @param string|null $default_value
		 *
		 * @return $this
		 */
		public function default_value(?string $default_value): AlterCmd {
			$this->default_value = $default_value;
			return $this;
		}
		
		/**
		 * Set column's DEFAULT_VALUE value in string
		 * You can use SQL Functions like 'TIMESTAMP()'
		 * @param string|null $on_update
		 *
		 * @return $this
		 */
		public function on_update(?string $on_update): AlterCmd {
			$this->on_update = $on_update;
			return $this;
		}
		
		/**
		 * Set column's order in table with AFTER clause
		 * @param string|null $after
		 *
		 * @return $this
		 */
		public function after(?string $after): AlterCmd {
			$this->after = $after;
			return $this;
		}
		
	}