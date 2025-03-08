<?php
	
	namespace sin5ddd\SQBuilder\Keys;
	
	use PHPUnit\Framework\TestCase;
	use sin5ddd\SQBuilder\SQL_TYPE;
	use sin5ddd\SQBuilder\SQBuilder;
	
	class SelectTest extends TestCase {
		
		public function testBuild() {
			$s = SQBuilder::make(SQL_TYPE::SELECT);
			$s->from("flyer_base", 'base');
			$s->join("stores", "base.store", "id")
			  ->join("flyer_section", "base.id", "flyer_id" ,"section")
				->join("flyer_items", "section.id", "section_id" ,"items")
			;
			$s
				->select("stores.name_j")
				->select("base.title")
				->select("release_in")
				->select("base.url")
				->select("lead_text")
				// ->select(Func::count("items.id", "item_count"))
				->order("release_in", -1)
				->where(Where::equal('store',1))
				->limit(5)
			;
			echo($s->build() . "\n");
			self::assertIsString($s->build());
		}
	}
