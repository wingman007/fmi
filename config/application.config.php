<?php
return array(
    'modules' => array(
        'Application',
<<<<<<< HEAD
        'Album', //this line is added
=======
        'Album',                  // <-- Add this line
        'ZhelyanGuglev',
        'AlexanderAlexandrov',                  // <-- Add this line
        'GyunerZeki',
        'StoyanCheresharov',                  // <-- Add this line
        'FmiStudent',                  // <-- Add this line
        'StudentBg',
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
