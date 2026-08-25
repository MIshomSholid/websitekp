<?php
// app/bootstrap.php - Core Bootstrap & Autoloader for Native MVC

date_default_timezone_set('Asia/Jakarta');

// Autoload classes from app/ directories
spl_autoload_register(function (string $class): void {
    $directories = [
        __DIR__ . '/config/',
        __DIR__ . '/helpers/',
        __DIR__ . '/models/',
        __DIR__ . '/controllers/'
    ];

    foreach ($directories as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Ensure Database is loaded and available
require_once __DIR__ . '/config/Database.php';
