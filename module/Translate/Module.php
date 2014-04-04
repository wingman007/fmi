<?php

namespace Translate;
// echo "<h1>Translate gets loaded</h1>";
class Module
{
    public function onBootstrap(\Zend\EventManager\EventInterface $e) { // use it to attach event listeners
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach('route', array($this, 'onRoute'), -100);
    }

    public function onRoute(\Zend\EventManager\EventInterface $e) { // Event manager of the app
		$application = $e->getApplication();
		$routeMatch = $e->getRouteMatch();
		$sm = $application->getServiceManager();
		
		$translator = $sm->get('translator'); // $routeMatch->getParam('lang');
		// By default, the translator will get the locale to use from the Intl extension’s Locale class. If you want to set an alternative locale explicitly, you can do so by passing it to the setLocale() method.
		// $translator->setLocale('bg_BG');
		// echo $_SERVER["HTTP_ACCEPT_LANGUAGE"];
		// allow intl extension
		$translator->setLocale(\Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
//-		echo '<h1>On Route</h1>';
		// echo $translator->getLocale();
	}
}