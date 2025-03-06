<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum METHOD: string {
		case MODIFY = "MODIFY IF EXISTS ";
		case ADD = "ADD IF NOT EXISTS ";
		case DROP = "DROP IF EXISTS ";
		
		case ADD_UNIQUE_KEY = "ADD CONSTRAINT %s UNIQUE (%s)";
		case ADD_PRIMARY_KEY = "ADD CONSTRAINT %s PRIMARY KEY (%s)";
		
		case CHANGE_NAME = "CHANGE IF EXISTS %s %s";
		case DROP_KEY = "DROP CONSTRAINT";
		case CREATE_FK = "ADD CONSTRAINT %s FOREIGN KEY (%s) REFERENCES %s (%s)";
		case FK_ON_DELETE_NULL  = "ON DELETE SET NULL";
		case FK_ON_DELETE_CASCADE  = "ON DELETE CASCADE";
	}