<?php
	
	namespace sin5ddd\SQBuilder\Builder\Interface;
	enum MIGRATION_TYPE {
		case UP;
		case DOWN;
		case BOTH;
		
	}
	abstract class IModifier extends ISQLBuilder {
		protected string $table_name;
		protected string $method;
		
		abstract public function __construct(string $table_name);
		
	}