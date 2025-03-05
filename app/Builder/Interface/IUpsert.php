<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	use sin5ddd\SQBuilder\Builder\Interface\IBuilder;
	
	abstract class IUpsert extends IBuilder {
		/**
		 * @var array<string, int|float|string|bool> $pairs
		 */
		protected array $pairs;
		
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
				$this->pairs[$key] = $value;
			}
			return $this;
		}
		
		
		public function setTableName(string $table_name): IUpsert {
			$this->table_name = $table_name;
			return $this;
		}
		
		abstract public function build(): string;
	}