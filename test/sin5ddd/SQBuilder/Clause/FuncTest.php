<?php
	
	namespace sin5ddd\SQBuilder\Clause;
	
	use PHPUnit\Framework\TestCase;
	
	class FuncTest extends TestCase {
		
		public function testCount() {
			self::assertEquals(Func::count("hoge"), 'COUNT(hoge)');
			self::assertEquals(Func::count("hoge",'hoge_count'), 'COUNT(hoge) AS hoge_count');
		}
		
		public function testMax() {
			self::assertEquals(Func::max("hoge"), 'MAX(hoge)');
			self::assertEquals(Func::max("hoge",'hoge_max'), 'MAX(hoge) AS hoge_max');
		}
		
		public function testMin() {
			self::assertEquals(Func::min("hoge"), 'MIN(hoge)');
			self::assertEquals(Func::min("hoge",'min'), 'MIN(hoge) AS min');
		}
		
		public function testCount_distinct() {
			self::assertEquals(Func::count_distinct("hoge"), 'COUNT(DISTINCT(hoge))');
			self::assertEquals(Func::count_distinct("hoge",'hoge'), 'COUNT(DISTINCT(hoge)) AS hoge');
		}
		
		public function testAvg() {
			self::assertEquals(Func::avg("hoge"), 'AVG(hoge)');
		}
		
		public function testSum() {
			self::assertEquals(Func::sum("hoge"), 'SUM(hoge)');
		}
	}
