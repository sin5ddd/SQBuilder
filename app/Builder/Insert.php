<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	
	class Insert extends IBuilder {
		/**
		 * @var array<string, int|float|string|bool> $values
		 */
		protected array  $values;
		protected string $into;
		
		/**
		 * @param array<string, int|float|string> $pair
		 *
		 * @throws Exception
		 */
		public function addPairs(array $pair): Insert {
			foreach ($pair as $key => $value) {
				if (gettype($key) !== "string") {
					throw new Exception('addPairs() method accepts key as string only');
				}
				$this->values[$key] = $value;
			}
			return $this;
		}
		
		public function build(): string {
			if (sizeof($this->values) == 0) {
				throw new Exception('upsert params are not specified yet');
			}
			if(!isset($this->into)){
				throw new Exception('into param needed');
			}
			$insert_fields = implode(', ', array_keys($this->values));
			$insert_values = implode(', ', EscapeValues::check_str(array_values($this->values)));
			
			$ret = "INSERT INTO $this->into ($insert_fields) VALUES ($insert_values)";
			
			return $ret;
		}
		
		public function setInto(string $into): Insert {
			$this->into = $into;
			return $this;
		}
	}