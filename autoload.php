<?php

// set autoloader to autoload models for convenience
spl_autoload_register(function ($cb) {
    $path_dir = __DIR__.'/Model/';
    $files = scandir($path_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $model_file = $path_dir . $file;
            include_once $model_file;
        }
    }
});
