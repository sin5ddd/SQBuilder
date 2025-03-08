<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	use sin5ddd\SQBuilder\Helper\EscapeValues;
	
	class Where extends ISQLKey {
		/**
		 * Compare with '='.
		 * @param string           $key column name
		 * @param string|int|float $value field value
		 *
		 * @return string
		 */
		static public function equal(string $key, string|int|float $value): string {
			return "$key = ".EscapeValues::check_str($value);
		}
		
		/**
		 * Compare field and value with '<>'
		 * @param string           $key
		 * @param string|int|float $value
		 *
		 * @return string
		 */
		static public function notEqual(string $key, string|int|float $value): string {
			return "$key <> ".EscapeValues::check_str($value);
		}
		
		/**
		 * Compare field and value with '>'
		 * value must be integer or float.
		 *
		 * @param string    $key
		 * @param int|float $value
		 *
		 * @return string
		 */
		static public function greater(string $key, int|float $value): string {
			return "$key > $value";
		}
		
		/**
		 * Compare field and value with '>='
		 * value must be integer or float.
		 *
		 * @param string    $key
		 * @param int|float $value
		 *
		 * @return string
		 */
		static public function greaterEqual(string $key, int|float $value): string {
			return "$key >= $value";
		}
		
		/**
		 * Compare field and value with '<'
		 * value must be integer or float.
		 *
		 * @param string    $key
		 * @param int|float $value
		 *
		 * @return string
		 */
		static public function less(string $key, int|float $value): string {
			return "$key < $value";
		}
		
		/**
		 * Compare field and value with '<='
		 * value must be integer or float.
		 *
		 * @param string    $key
		 * @param int|float $value
		 *
		 * @return string
		 */
		static public function lessEqual(string $key, int|float $value): string {
			return "$key <= $value";
		}
		
		/**
		 * Compare field and values with 'IN' statement
		 * values must be integer|float|string.
		 *
		 * @param string $key
		 * @param array<int|float|string> $values
		 *
		 * @return string
		 * @throws \Exception
		 */
		static public function in(string $key, array $values): string {
			if(sizeof($values) < 2) {
				throw new \Exception("IN statement needs at least 2 values");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(', ', $values);
			return "$key IN ($arr_str)";
		}
		
		/**
		 * Compare field and value with 'NOT IN' statement.
		 * values must be integer|float|string.
		 *
		 * @param string $key
		 * @param array<int|float|string>  $values
		 *
		 * @return string
		 * @throws \Exception
		 */
		static public function notIn(string $key, array $values): string {
			if(sizeof($values) < 2) {
				throw new \Exception("NOT IN statement needs at least 2 values");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(', ', $values);
			return "$key NOT IN ($arr_str)";
		}
		
		/**
		 * Compare field and value with 'BETWEEN xx AND yy' statement.
		 * values must be integer or float, and accept only 2 values.
		 *
		 * @param string $key
		 * @param array<int|float>  $values
		 *
		 * @return string
		 * @throws \Exception
		 */
		static public function between(string $key, array $values): string {
			if(sizeof($values) !== 2) {
				throw new \Exception("Between statement accepts 2 values only");
			}
			$values = EscapeValues::check_str($values); // DateTimeの場合もあるため、文字列エスケープする
			$arr_str = implode(' AND ', $values);
			return "$key BETWEEN $arr_str";
		}
		
		/**
		 * Compare field and value with 'NOT BETWEEN xx AND yy' statement.
		 * values must be integer or float, and accept only 2 values.
		 *
		 * @param string $key
		 * @param array  $values
		 *
		 * @return string
		 * @throws \Exception
		 */
		static public function notBetween(string $key, array $values): string {
			if(sizeof($values) !== 2) {
				throw new \Exception("NOT Between statement accepts 2 values only");
			}
			$values = EscapeValues::check_str($values);
			$arr_str = implode(' AND ', $values);
			return "$key NOT BETWEEN $arr_str";
		}
	}