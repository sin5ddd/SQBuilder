<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum INDEX:string{
		case CREATE_INDEX = "CREATE INDEX %s ON %s (%s)";
		case DROP_INDEX = "DROP INDEX %s ON %s";
	}
	
	