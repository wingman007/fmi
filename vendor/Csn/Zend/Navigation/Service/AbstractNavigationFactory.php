<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Csn\Zend\Navigation\Service;

use Csn\Zend\Navigation\Navigation;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract navigation factory
 */
// abstract class AbstractNavigationFactory implements FactoryInterface
abstract class AbstractNavigationFactory extends \Zend\Navigation\Service\AbstractNavigationFactory
{
	/**
	* @override
	*/
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pages = $this->getPages($serviceLocator);
        return new Navigation($pages);
    }
}
