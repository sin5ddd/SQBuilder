<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	
	abstract class IBuilder {
		private array    $params     = [];
		protected string $table_name = '';
		protected string $method;
		protected string $key;
		
		
		
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
		
		public function buildToFile(?string $path = null): void{
			$this->toFile($this->build(),$path);
		}
		protected function toFile(string $sql_str,?string $path = null, ?string $type = null): void {
			if(is_null($path)) {
				$path = __DIR__."/";
			}
			if(!file_exists($path)){
				mkdir($path,0777,true);
			}
			$datetime = date('Y_m_d_His');
			$filename = $datetime."_".$this->table_name."_".$this->method;
			if(!is_null($type)) {
				$filename .= "_".$type;
			}
			$filename .= ".sql";
			
			file_put_contents($path.$filename,$sql_str);
		}
		
}