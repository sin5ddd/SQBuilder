<?php
	
	namespace sin5ddd\SQBuilder\Clause;
	
	class Func extends IClause {
		/**
		 * returns "COUNT($key) AS $as" SQL Function statement
		 * when $as is not set, returns without "AS".
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function count(string $key, ?string $as=null):string {
			return self::bake("COUNT($key)",$as);
		}
		
		/**
		 *  returns "COUNT(DISTINCT($key)) AS $as" SQL Function statement
		 *  when $as is not set, returns without 'AS'.
		 *
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function count_distinct(string $key, ?string $as=null):string {
			return self::bake("COUNT(DISTINCT($key))",$as);
		}
		
		/**
		 * returns "SUM($key) AS $as" SQL Function statement
		 * when $as is not set, returns without 'AS'.
		 *
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function sum(string $key, ?string $as=null):string {
			return self::bake("SUM($key)",$as);
		}
		
		/**
		 * returns "MAX($key) AS $as" SQL Function statement
		 * when $as is not set, returns without 'AS'.
		 *
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function max(string $key, ?string $as=null):string {
			return self::bake("MAX($key)",$as);
		}
		
		/**
		 *  returns "MIN($key) AS $as" SQL Function statement
		 *  when $as is not set, returns without 'AS'.
		 *
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function min(string $key, ?string $as=null):string {
			return self::bake("MIN($key)",$as);
		}
		
		/**
		 * returns "AVG($key) AS $as" SQL Function statement
		 * when $as is not set, returns without 'AS'.
		 * @param string      $key
		 * @param string|null $as
		 *
		 * @return string
		 */
		static public function avg(string $key, ?string $as=null):string {
			return self::bake("AVG($key)",$as);
		}
		
		/**
		 * returns simply "TIMESTAMP()" SQL Function statement
		 *
		 * @return string
		 */
		static private function timestamp():string{
			return self::bake("TIMESTAMP()",null);
		}
		
		/**
		 * Build and return statement SQL Function statement
		 *
		 * @param string      $fn
		 * @param string|null $as
		 *
		 * @return string
		 */
		static private function bake(string $fn, ?string $as):string {
			return $as ? $fn." AS $as" : $fn;
		}
	}