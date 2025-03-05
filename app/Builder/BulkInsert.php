<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class BulkInsert extends IUpsert {
		protected array $columns = [];
		protected array $pairs   = [];
		
		protected array $values  = [];
		
		/**
		 * カラムが一致しなくてもInsertするかどうかのチェック
		 * デフォルトではカラムが一致しない場合は例外を吐く
		 *
		 * @var bool
		 */
		private bool $accept_empty = true;
		
		public function __construct() { $this->method = "bulk-insert"; }
		
		public function addPairs(array $pair): IUpsert {
			// 最初のレコードのカラム名を保管
			if (sizeof($this->columns) == 0) {
				$this->columns = array_keys($pair);
			} else { // 2個め以降はカラムがマッチするか確認してから追加
				if(!in_array(array_keys($pair), $this->columns, true)) {
					$this->columns = array_merge($this->columns, array_keys($pair));
				}
			}
			
			$this->pairs[] = $pair;
			return $this;
		}
		
		/**
		 * CSVなどからのアップに利用するイメージ
		 * 2次元配列の1行目をカラム名とする
		 *
		 * @param array<array> $pairs
		 *
		 * @return IUpsert
		 * @throws \Exception
		 */
		public function bulkAddPairs(array $pairs): IUpsert {
			foreach ($pairs as $pair) {
				if (sizeof($this->columns) == 0) {
					$this->columns = array_keys($pair);
				} else {
					$this->addPairs($pair);
				}
			}
			return $this;
		}
		
		protected function normalizeArray(){
			for ($i = 0; $i < sizeof($this->pairs); $i++) {
				foreach ($this->columns as $c) {
					if (!array_key_exists($c,$this->pairs[$i])) {
						$this->pairs[$i][$c] = null;
					}
				}
				$this->values[] = array_values($this->pairs[$i]);
			}
		}
		
		public function build(): string {
			$str_columns = implode(', ', $this->columns);
			$values_arr  = [];
			foreach ($this->values as $value) {
				$values_arr[] = implode(', ', $value);
			}
			$str_values = implode('), (', $values_arr);
			$ret        = "INSERT INTO $this->table_name ($str_columns) VALUES ($str_values)";
			return $ret;
		}
		
		/**
		 * データ未入力のカラムを許可するかどうか
		 * falseの場合は例外、trueの場合はnullで埋める
		 *
		 * @param $ignore = true
		 *
		 * @return $this
		 */
		public function acceptEmpty(bool $ignore = true): BulkInsert {
			$this->accept_empty = $ignore;
			return $this;
		}
	}