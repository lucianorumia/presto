<?php
namespace Back\Cross;

use \Exception;

enum CstmExceptions: int {
    case WRONG_LOGIN_DATA = 1001;
    case INVALID_FILEPATH = 2;
    case NONEXISTENT_FILEPATH = 3;
    case FILE_NOT_FOUND = 4;
    case REQUIRE_ERROR = 5;
    case INCLUDE_ERROR = 10;
    case NO_FRAN = 6;
    case NO_TOKEN = 60;
    case INVALID_FRAN = 7;
    case INVALID_TOKEN = 70;
    case INPUT_VALIDATE_ERROR = 8;
    case INVALID_AIDE = 9;
    case CLASS_AUTOLOAD_ERROR = 11;
    case NO_REQUEST = 12;
    case SQL_ERROR = 13;

    public function msg(): string {         
        return match($this) {             
            self::WRONG_LOGIN_DATA => 'Wrong login data',
            self::INVALID_FILEPATH => 'Invalid filepath',
            self::NONEXISTENT_FILEPATH => 'Nonexistent filepath',
            self::FILE_NOT_FOUND => 'Archivo no encontrado',
            self::REQUIRE_ERROR => 'Require error',
            self::INCLUDE_ERROR => 'Include error',
            self::CLASS_AUTOLOAD_ERROR => 'Class Autoload Error',
            self::NO_FRAN => 'No fran key',
            self::NO_TOKEN => 'No token',
            self::INVALID_FRAN => 'Invalid Fran key',
            self::INVALID_TOKEN => 'Invalid token',
            self::INPUT_VALIDATE_ERROR => 'Input validate error',
            self::INVALID_AIDE => 'Invalid Aide key',
            self::NO_REQUEST => 'No request',
            self::SQL_ERROR => 'SQL Error',
        };     
    }
}

class CstmException extends Exception {
    public function __construct(CstmExceptions $cstm_ex, string $extra_info = null) {
        parent::__construct($cstm_ex->msg() . ($extra_info ? " ($extra_info)" : ''), $cstm_ex->value);
    }
}
