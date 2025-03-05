<?php
	
	namespace sin5ddd\SQBuilder\Builder;
	
	use Exception;
	use sin5ddd\SQBuilder\Builder\Interface\IBuilder;
	
	class Select extends IBuilder {
		
		private array $select = [];
		private array $join   = [];
		private array $group  = [];
		private array $where  = [];
		private array $order  = [];
		private int   $limit  = 0;
		private int   $offset = 0;
		private int   $page   = 1;
		
		public function __construct() {
			$this->method = 'select';
		}
		
		/**
		 * @param int $limit 1未満の場合はLIMIT句は生成されない
		 *
		 * @return Select
		 */
		public function limit(int $limit): self {
			$this->limit = $limit;
			return $this;
		}
		
		public function build(): string {
			if (empty($this->select)) {
				throw new Exception("QueryBuilder: no SELECT field specified.");
			}
			if (empty($this->table_name)) {
				throw new Exception("QueryBuilder: no FROM table specified.");
			}
			$ret = "SELECT ";
			$ret .= implode(', ', $this->select);
			$ret .= " FROM {$this->table_name}";
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
			if ($this->page > 1 && $this->offset > 0) {
				$this->offset = $this->limit * $this->page;
			}
			if ($this->offset > 0) {
				$ret .= " OFFSET $this->offset";
			}
			return $ret;
		}
		
		/**
		 * @param string|array $args
		 *
		 * @return Select
		 * @throws Exception
		 */
		public function select(string|array $args): self {
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
		
		/**
		 * LEFT JOINのみ対応
		 *
		 * @param string  $table_name
		 * @param string  $master_key
		 * @param ?string $table_key 指定されない場合はマスター側と同名のカラムを取得します
		 * @param ?string $append_cond
		 *
		 *
		 * @return $this
		 */
		public function join(string $table_name, string $master_key, string $table_key, ?string $as=null, ?string $append_cond = null): self {
			if($as){
				$table_name.=" AS $as";
			}
			$join_state = "LEFT JOIN $table_name ON $master_key = $table_name.$table_key";
			if (!is_null($append_cond)) {
				$join_state .= " AND $append_cond";
			}
			if ($join_state !== '') {
				$this->join[] = $join_state;
			}
			return $this;
		}
		
		/**
		 * @param string $arg
		 *
		 * @return Select
		 */
		public function from(string $arg): self {
			$this->table_name = $arg;
			return $this;
		}
		
		public function where(string $condition): self {
			$this->where[] = $condition;
			return $this;
		}
	}