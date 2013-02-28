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

return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=viktorfmi;host=viktorfmi-db.my.phpcloud.com',
        'username'       => 'viktorfmi',
        'password'       => '166victor196',
=======
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
//    'dsn' => 'mysql:dbname=wingman;host=wingman-db.my.phpcloud.com',
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
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
<<<<<<< HEAD
);
=======
);
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
