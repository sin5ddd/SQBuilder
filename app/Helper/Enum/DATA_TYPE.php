<?php
	
	namespace sin5ddd\SQBuilder\Helper\Enum;
	
	enum DATA_TYPE: string {
		case INT = "INT"; // max 2,147,483,647
		case UINT = "INT UNSIGNED"; // max 4,294,967,295
		case INT1 = "INT1"; // = TINYINT(4), max 127
		case UINT1 = "INT1 UNSIGNED"; // = TINYINT(4), max 255
		case INT2 = "INT2"; // = SMALLINT(6), max 32767
		case UINT2 = "INT2 UNSIGNED"; // = SMALLINT(6), max 65535
		case INT3 = "INT3"; // = MEDIUMINT(9)
		case UINT3 = "INT3 UNSIGNED";
		case INT4 = "INT4"; // = INT(11)
		case UINT4 = "INT4 UNSIGNED"; // = INT(11)
		case INT8 = "INT8"; // = BIGINT(20), max 9,223,372,036,854,775,807
		case UINT8 = "INT8 UNSIGNED"; // = BIGINT(20), max 18,446,744,073,709,551,615
		case LONG = "LONG"; // = MIDIUMTEXT, max NaN
		case TINYINT = "TINYINT"; // max 127
		case U_TINYINT = "TINYINT UNSIGNED"; // max 255
		case SMALLINT = "SMALLINT"; // max 32,767
		case U_SMALLINT = "SMALLINT UNSIGNED"; // max 65,535
		case MEDIUMINT = "MEDIUMINT"; // max 8,388,607
		case U_MEDIUMINT = "MEDIUMINT UNSIGNED"; // max 16,777,215
		case BIGINT = "BIGINT"; // max 9,223,372,036,854,775,807 = BIGINT(20)
		case U_BIGINT = "BIGINT UNSIGNED"; // max 9,223,372,036,854,775,807 = BIGINT(20) マイナス不可
		case VARCHAR = "VARCHAR";
		case TEXT = "TEXT";
		case TINYTEXT = "TINYTEXT";
		case MEDIUMTEXT = "MEDIUMTEXT";
		case LONGTEXT = "LONGTEXT";
		case DATETIME = "DATETIME";
		case TIMESTAMP = "TIMESTAMP";
		case BOOLEAN = "BOOLEAN"; // = TINYINT(1)
		case BOOL = "BOOL"; // = TINYINT(1)
		case BIT = "BIT"; // = BIT(1) => true or false
		case DATE = "DATE";
		case TIME = "TIME";
		case FLOAT = "FLOAT";
		case U_FLOAT = "FLOAT UNSIGNED";
		case FLOAT4 = "FLOAT4"; // = FLOAT
		case U_FLOAT4 = "FLOAT4 UNSIGNED";
		case FLOAT8 = "FLOAT8"; // = DOUBLE
		case U_FLOAT8 = "FLOAT8 UNSIGNED";
		case DOUBLE = "DOUBLE";
		case U_DOUBLE = "DOUBLE UNSIGNED";
	}