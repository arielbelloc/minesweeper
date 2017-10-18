<?php
spl_autoload_register(
    function($class) {
        $parts = explode('\\', $class);
        require __DIR__ . '/' . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
    }
);