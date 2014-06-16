<h1>Cubbyhole is under maintenance</h1>

We are currently under maintenance please retry in some minutes.

<?php
die();
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
