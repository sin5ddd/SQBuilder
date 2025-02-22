<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	
	class Where extends ISQLKey {
		static public function equal(string $key, string|int|float $value): string {
			return "$key = ".self::check_str($value);
		}
		
		static public function notEqual(string $key, string|int|float $value): string {
			return "$key <> ".self::check_str($value);
		}
		
		static public function greater(string $key, int|float $value): string {
			return "$key > $value";
		}
		
		static public function greaterEqual(string $key, int|float $value): string {
			return "$key >= $value";
		}
		
		static public function less(string $key, int|float $value): string {
			return "$key < $value";
		}
		
		static public function lessEqual(string $key, int|float $value): string {
			return "$key <= $value";
		}
		
		static public function in(string $key, array $values): string {
			if(sizeof($values) < 2) {
				throw new \Exception("IN statement needs at least 2 values");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(', ', $values);
			return "$key IN ($arr_str)";
		}
		
		static public function notIn(string $key, array $values): string {
			if(sizeof($values) < 2) {
				throw new \Exception("NOT IN statement needs at least 2 values");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(', ', $values);
			return "$key NOT IN ($arr_str)";
		}
		
		static public function between(string $key, array $values): string {
			if(sizeof($values) !== 2) {
				throw new \Exception("Between statement accepts 2 values only");
			}
			$values = EscapeValues::check_str($values); // DateTimeの場合もあるため、文字列エスケープする
			$arr_str = implode(' AND ', $values);
			return "$key BETWEEN $arr_str";
		}
		
		static public function notBetween(string $key, array $values): string {
			if(sizeof($values) !== 2) {
				throw new \Exception("NOT Between statement accepts 2 values only");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(' AND ', $values);
			return "$key NOT BETWEEN $arr_str";
		}
	}