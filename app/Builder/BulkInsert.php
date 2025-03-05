<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	use sin5ddd\SQBuilder\Builder\Interface\IUpsert;
	
	class BulkInsert extends IUpsert {
		/**
		 * 検索しやすいようにkeyでカラム名を持つ
		 * 値はダミー
		 *
		 * @var array
		 */
		protected array $columns = [];
		protected array $pairs   = [];
		
		protected array $values = [];
		
		/**
		 * カラムが一致しなくてもInsertするかどうかのチェック
		 * デフォルトではカラムが一致しない場合は例外を吐く
		 *
		 * @var bool
		 */
		private bool $accept_null = true;
		
		public function __construct() { $this->method = "bulk-insert"; }
		
		public function addPairs(array $pair): IUpsert {
			if (sizeof($this->columns) == 0) {
				// 1️回目はそのまま追加
				$this->columns = $pair;
			} else {
				$column_dif = array_diff_key($pair,$this->columns);
				// columnの差を追加する
				// 冗長だけど毎回全検索するよりは速い
				foreach ($column_dif as $k=>$v) {
					$this->columns[$k] = 0;
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
				$this->addPairs($pair);
			}
			return $this;
		}
		
		protected function normalizeArray(): void {
			for ($i = 0; $i < sizeof($this->pairs); $i++) {
				foreach (array_keys($this->columns) as $c) {
					if (!array_key_exists($c, $this->pairs[$i])) {
						$this->pairs[$i][$c] = null;
					}
				}
				$this->values[] = EscapeValues::check_str(array_values($this->pairs[$i]),$this->accept_null);
			}
		}
		
		public function build(): string {
			if (sizeof($this->values) == 0) {
				$this->normalizeArray();
			}
			$str_columns = implode(', ', array_keys($this->columns));
			$values_arr  = [];
			foreach ($this->values as $value) {
				$values_arr[] = implode(', ', $value);
			}
			$str_values = implode('), (', $values_arr);
			$ret        = "INSERT INTO $this->table_name ($str_columns) VALUES ($str_values)";
			return $ret;
		}
		
		/**
		 * データ未入力のカラムの処理方法
		 * falseの場合は空文字列、trueの場合はnullで埋める
		 *
		 * @param $accept = true
		 *
		 * @return $this
		 */
		public function acceptNull(bool $accept = true): BulkInsert {
			$this->accept_null = $accept;
			return $this;
		}
	}