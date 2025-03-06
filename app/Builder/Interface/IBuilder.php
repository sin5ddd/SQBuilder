<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	
	abstract class IBuilder extends ISQLBuilder {
		private array    $params     = [];
		protected string $table_name = '';
		protected string $method;
		protected string $key;
		
		/**
		 * $this->methodを必ず指定する
		 */
		abstract public function __construct();
		
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
		
		
}