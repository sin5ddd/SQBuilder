<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum PHP_TYPE: string {
		case FLOAT = 'float';
		case INT = 'int';
		case STRING = 'string';
		case BOOL = 'bool';
		case ARRAY = 'array';
		case OBJECT = 'object';
		case DATETIME = '\DateTimeImmutable';
	}