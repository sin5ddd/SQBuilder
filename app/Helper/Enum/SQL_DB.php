<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum SQL_DB {
		case MYSQL;
		case MARIADB;
		case SQLSERVER;
		case POSTGRESQL;
	}