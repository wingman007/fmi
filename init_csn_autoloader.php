<?php
// Composer autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

$csnPath = false;

if (is_dir('vendor')) { // vendor/ZF2/library
    $csnPath = 'vendor'; // notice how we are in the folder where the library should be
} elseif (getenv('CSN_PATH')) {      // Support for ZF2_PATH environment variable or git submodule
    $csnPath = getenv('CSN_PATH');
} elseif (get_cfg_var('csn_path')) { // Support for zf2_path directive value
    $csnPath = get_cfg_var('csn_path');
}

if ($csnPath) {
    if (isset($loader)) {
        $loader->add('Csn', $csnPath);
    } else {
	// ToDo fix it so it works with Csn
        include $csnPath . '/Zend/Loader/AutoloaderFactory.php';
        Zend\Loader\AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true
            )
        ));
    }
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load CSN. Run `php composer.phar install` or define a CSN_PATH environment variable.');
}
