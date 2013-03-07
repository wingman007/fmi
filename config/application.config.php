<?php
return array(
    'modules' => array(
        'Application',
        'Album', //this line is added
        'ZhelyanGuglev',
        'AlexanderAlexandrov',                  // <-- Add this line
        'GyunerZeki',
        'StoyanCheresharov',                  // <-- Add this line
        'FmiStudent',                  // <-- Add this line
        'StudentBg',
        'VictorAtanassov',                  // <-- Add this line
        'Elena',                  // <-- Add this line
        'MargaritaKrushkova',
    'IvelinaVelcheva',
    'MihaelaKerkenekova',
    'MartinManov',
	'MarinaGatova',
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
