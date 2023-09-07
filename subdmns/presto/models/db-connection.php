<?php
namespace Back\Models;

use \PDO;
use \Throwable;

class DbConnection extends PDO {
    
    public function __construct(){
        $sdn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        parent::__construct($sdn, DB_USER, DB_PASS, $options);
        $this->exec('SET CHARACTER SET ' . DB_CHARSET);
    }
}
