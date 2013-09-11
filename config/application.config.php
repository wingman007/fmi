<?php
return array(
    'modules' => array(
        'Application',
		'DoctrineModule',
		'DoctrineORMModule',
//		'DoctrineMongoODMModule',

        'Album', //this line is added
        'ZhelyanGuglev',
        'AlexanderAlexandrov',                  // <-- Add this line
        'GyunerZeki',
        'StoyanCheresharov',                  // <-- Add this line
        'FmiStudent',                  // <-- Add this line
        'StudentBg',
        'VictorAtanassov',                  // <-- Add this line
        'Elena',                  // <-- Add this line
        'AntonTonev',
        'MargaritaKrushkova',
        'StoyanAtanasoff',
		'IvelinaVelcheva',
		'MihaelaKerkenekova',
		'MartinManov',
		'MarinaGatova',
		'PaolaShumanova',
		'NikoletaPoibrenska',
		'PetyaStavarova',
		// 'VanyaDimitrova',
		'ElitsaNedyalkova',
		'VasilVasilev',
		'NikolaiBaldjiev',
		'NeslihanSuleyman',
		'MihailKopuscu',
		'RallNic',
		'KrasimirTsvetanov',
		'Fmi',
//		'Auth', // if you want to enable AuthDoctrine disable the module Auth. They register the same services
		'CsnBase', // This is also a library. Can be used without adding it as a module in composer.json: "autoload": {"psr-0": {"CsnBase\\": "vendor/coolcsn/csn-base/src/"}}
		'CsnUser',
		'CsnAuthorize', // uncomment if you want to use Authorization
		'AuthDoctrine', // if you want to enable AuthDoctrine disable the module Auth. They register the same services
		'CsnNavigation', // this module simply adds ACL to navigation
		'CsnCms',
		'CsnFileManager',
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
