<?php
/**
<<<<<<< HEAD
* Global Configuration Override
*
* You can use this file for overridding configuration values from modules, etc.
* You would place values in here that are agnostic to the environment and not
* sensitive to security.
*
* @NOTE: In practice, this file will typically be INCLUDED in your source
* control, so do not include passwords or other sensitive information in this
* file.
*/

/*
return array(
// ...
);
*/

return array(
    'db' => array(
        'driver' => 'Pdo',
// 'dsn' => 'mysql:dbname=wingman;host=wingman-db.my.phpcloud.com',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);

