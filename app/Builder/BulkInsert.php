<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class BulkInsert extends IUpsert {
		private array   $columns = [];
		protected array $values  = [];
		
		/**
		 * カラムが一致しなくてもInsertするかどうかのチェック
		 * デフォルトではカラムが一致しない場合は例外を吐く
		 *
		 * @var bool
		 */
		private bool $ignore_empty = false;
		
		public function addPairs(array $pair): IUpsert {
			// $valuesをレコードとして保管する
			// 最初のレコードのカラム名を保管
			if (sizeof($this->columns) == 0) {
				$this->columns = array_keys($pair);
			} else { // 2個め以降はカラムがマッチするか確認してから追加
				if ($this->columns !== array_keys($pair) && !$this->ignore_empty) {
					throw new \Exception('column name not match');
				}
			}
			
			$this->values[] = EscapeValues::check_str(array_values($pair));
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
		
		public function build(): string {
			// var_dump($this->values);die;
			$str_columns = implode(', ', $this->columns);
			$values_arr  = [];
			foreach ($this->values as $value) {
				$values_arr[] = implode(', ', $value);
			}
			$str_values = implode('), (', $values_arr);
			$ret        = "INSERT INTO $this->table ($str_columns) VALUES ($str_values)";
			return $ret;
		}
		
		public function ignoreEmpty($ignore = true): BulkInsert {
			$this->ignore_empty = $ignore;
			return $this;
		}
	}