<?php
date_default_timezone_set('America/Los_Angeles'); 
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
ini_set('display_errors', '1');
chdir(dirname(__DIR__));

// Setup autoloading
include 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run();
