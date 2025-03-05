<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	class ISQLBuilder {
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