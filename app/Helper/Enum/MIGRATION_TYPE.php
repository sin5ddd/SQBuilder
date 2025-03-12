<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum MIGRATION_TYPE {
		case UP;
		case DOWN;
		case BOTH;
		
	}