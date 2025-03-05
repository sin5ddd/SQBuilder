<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	
	abstract class IBuilder {
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