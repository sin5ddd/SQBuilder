<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	use sin5ddd\SQBuilder\Builder\Interface\IBuilder;
	
	abstract class IUpsert extends IBuilder {
		/**
		 * @var array<string, int|float|string|bool> $values
		 */
		protected array  $values;
		protected string $table;
		
		/**
		 * @param array<string, int|float|string> $pair
		 *
		 * @throws Exception
		 */
		public function addPairs(array $pair): IUpsert {
			foreach ($pair as $key => $value) {
				if (gettype($key) !== "string") {
					throw new Exception('addPairs() method accepts key as string only');
				}
				$this->values[$key] = $value;
			}
			return $this;
		}
		
		
		public function setTable(string $table): IUpsert {
			$this->table = $table;
			return $this;
		}
		
		abstract public function build(): string;
	}