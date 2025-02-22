<?php
	
	namespace sin5ddd\SQBuilder;
	
	use Exception;
	use sin5ddd\SQBuilder\Builder\{
		Insert,
		Update,
		Select};
	
	enum SQL_TYPE {
		case SELECT;
		case INSERT;
		case UPDATE;
		case UPSERT;
		case DELETE;
		case CREATE;
		case DROP;
	}
	
	class SQBuilder {
		private function __construct() {}
		static public function make(SQL_TYPE $type) {
			// $this->params = $this->parse(func_get_args());
			return match ($type) {
				SQL_TYPE::SELECT => new Select(),
				SQL_TYPE::INSERT => new Insert(),
				SQL_TYPE::UPDATE => new Update(),
				default          => new Select(),
			};
		}
	}