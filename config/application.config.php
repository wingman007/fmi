<?php
return array(
    'modules' => array(
        'Application',
        'Album',                  // <-- Add this line
        'ZhelyanGuglev',
        'AlexanderAlexandrov',                  // <-- Add this line
        'GyunerZeki',
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
