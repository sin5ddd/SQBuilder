<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	class Func extends ISQLKey {
		static public function count(string $key, ?string $as):string {
			$ret = "COUNT($key)";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
		
		static public function count_distinct(string $key, ?string $as):string {
			$ret = "COUNT(DISTINCT($key))";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
		
		static public function sum(string $key, ?string $as):string {
			$ret = "SUM($key)";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
		
		static public function max(string $key, ?string $as):string {
			$ret = "MAX($key)";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
		
		static public function min(string $key, ?string $as):string {
			$ret = "MIN($key)";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
		
		static public function avg(string $key, ?string $as):string {
			$ret = "AVG($key)";
			if($as){
				$ret .= " AS $as";
			}
			return $ret;
		}
	}