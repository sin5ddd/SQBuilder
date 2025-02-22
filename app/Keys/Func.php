<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	class Func extends ISQLKey {
		static public function count(string $key, ?string $as=null):string {
			return self::bake("COUNT($key)",$as);
		}
		
		static public function count_distinct(string $key, ?string $as=null):string {
			return self::bake("COUNT(DISTINCT($key))",$as);
		}
		
		static public function sum(string $key, ?string $as=null):string {
			return self::bake("SUM($key)",$as);
		}
		
		static public function max(string $key, ?string $as=null):string {
			return self::bake("MAX($key)",$as);
		}
		
		static public function min(string $key, ?string $as=null):string {
			return self::bake("MIN($key)",$as);
		}
		
		static public function avg(string $key, ?string $as=null):string {
			return self::bake("AVG($key)",$as);
		}
		
		static private function bake(string $fn,?string $as):string {
			return $as ? $fn." AS $as" : $fn;
		}
	}