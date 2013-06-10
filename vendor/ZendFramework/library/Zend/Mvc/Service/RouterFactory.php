<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\Service;

use Zend\Console\Console;
use Zend\Mvc\Router\Console\SimpleRouteStack as ConsoleRouter;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouterFactory implements FactoryInterface
{
    /**
     * Create and return the router
     *
     * Retrieves the "router" key of the Config service, and uses it
     * to instantiate the router. Uses the TreeRouteStack implementation by
     * default.
     *
     * @param  ServiceLocatorInterface        $serviceLocator
     * @param  string|null                     $cName
     * @param  string|null                     $rName
     * @return \Zend\Mvc\Router\RouteStackInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $cName = null, $rName = null)
    {
        $config             = $serviceLocator->get('Config');
        $routePluginManager = $serviceLocator->get('RoutePluginManager');

        if (
            $rName === 'ConsoleRouter' ||                   // force console router
            ($cName === 'router' && Console::isConsole())       // auto detect console
        ) {
            // We are in a console, use console router.
            if (isset($config['console']) && isset($config['console']['router'])) {
                $routerConfig = $config['console']['router'];
            } else {
                $routerConfig = array();
            }

            $router = new ConsoleRouter($routePluginManager);
        } else {
            // This is an HTTP request, so use HTTP router
            $router       = new HttpRouter($routePluginManager);
            $routerConfig = isset($config['router']) ? $config['router'] : array();
        }

        if (isset($routerConfig['route_plugins'])) {
            $router->setRoutePluginManager($routerConfig['route_plugins']);
        }

        if (isset($routerConfig['routes'])) {
            $router->addRoutes($routerConfig['routes']);
        }

        if (isset($routerConfig['default_params'])) {
            $router->setDefaultParams($routerConfig['default_params']);
        }

        return $router;
    }
}
