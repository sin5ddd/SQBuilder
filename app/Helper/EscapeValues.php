<?php
	
	namespace sin5ddd\SQBuilder\Helper;
	
	class EscapeValues {
		static public function check_str($value, bool $accept_null = true) {
			if (is_string($value)) {
				$value = "'$value'";
			} else if (is_bool($value)) {
				$value = intval($value); // MySQL・SQLiteのみ
			} else if (is_null($value)) {
				if ($accept_null) {
					$value = 'NULL';
				} else {
					$value = '""';
				}
			}
			if (is_array($value)) {
				for ($i = 0; $i < sizeof($value); $i++) {
					$value[$i] = self::check_str($value[$i]);
				}
			}
			return $value;
		}
		
		static public function check_num($value) {
			if (is_string($value)) {
				throw new \Exception("value '$value' is not a number'");
			}
			if (is_array($value)) {
				for ($i = 0; $i < sizeof($value); $i++) {
					self::check_num($value[$i]);
				}
			}
		}
	}