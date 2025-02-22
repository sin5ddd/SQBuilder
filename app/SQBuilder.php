<?php
	
	namespace sin5ddd\SQBuilder;
	
	use Exception;
	use sin5ddd\SQBuilder\Builder\IBuilder;
	use sin5ddd\SQBuilder\Builder\Select;
	
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
		static public function make(SQL_TYPE $type): IBuilder {
			// $this->params = $this->parse(func_get_args());
			return match ($type) {
				SQL_TYPE::SELECT => new Select(),
				default          => new Select(),
			};
		}
	}