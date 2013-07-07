<?php

spl_autoload_register(function($class)
{
    if(DIRECTORY_SEPARATOR !== '\\') {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    }

    $class_path = __DIR__.DIRECTORY_SEPARATOR.$class.'.php';

    if(file_exists($class_path)) {
        include($class_path);
    } else {
        // Try /test

        $class_path = dirname(__DIR__).DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.$class.'.php';

        if(file_exists($class_path)) {
            include($class_path);
        }
    }
    
}, true);