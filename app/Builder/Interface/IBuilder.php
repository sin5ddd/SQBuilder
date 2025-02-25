<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	
	use Exception;
	
	abstract class IBuilder {
		
		/**
		 * SQL文書き出し(仮想関数)
		 * @return string
		 * @throws Exception
		 */
		abstract public function build(): string;
		
}