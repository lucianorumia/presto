<?php
namespace Back\Cross;

use \Throwable;
use Back\Cross\CstmException;

require_once __DIR__ . '/config.php';

spl_autoload_register(function($class){
    try {
        $class_filepath = Router::getFilePath($class);

        if (file_exists($class_filepath)) {
            require_once $class_filepath;
        } else {
            throw new CstmException(CstmExceptions::CLASS_AUTOLOAD_ERROR, 'class file not found');
        }
    } catch (Throwable $th) {
        echo $th->getMessage(); 
    }
});

class Router {

    private static function nsToRealPath($ns_filepath) {
        $levels = explode('\\', $ns_filepath);

        foreach ($levels as &$level) {
            $level = lcfirst($level);
            for ($i = 1; $i < strlen($level); $i++) {
                if (ctype_alpha($level[$i]) && $level[$i] === strtoupper($level[$i])) {
                    $replace = '-' . strtolower($level[$i]);
                    $level = substr_replace($level, $replace, $i, 1);
                }
            }
        }

        $parent_level = $levels[0];
        
        if (array_key_exists($parent_level, PATHS)) {
            $parent_dir = PATHS[$parent_level];
        } else {
            throw new CstmException(CstmExceptions::CLASS_AUTOLOAD_ERROR, 'invalid class path');
        }

        $filename_index = count($levels) - 1;
        $filename = $levels[$filename_index];

        if ($filename_index > 1) {
            $midle_path = implode('/', array_slice($levels, 1, -1));
            $real_filepath = "$parent_dir/$midle_path/$filename.php";
        } elseif ($filename_index === 1) {
            $real_filepath = "$parent_dir/$filename.php";
        } else {
            throw new CstmException(CstmExceptions::CLASS_AUTOLOAD_ERROR, 'invalid class path');
        }

        return $real_filepath;
    }

    public static function getFilePath($ns_filepath) {
        return self::nsToRealPath($ns_filepath);
    }
}