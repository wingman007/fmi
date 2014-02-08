<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Csn\Zend\Navigation\Page;

// use Traversable;
// use Csn\Zend\Navigation\AbstractContainer;
// use Zend\Navigation\Exception;
// use Zend\Permissions\Acl\Resource\ResourceInterface as AclResource;
// use Zend\Stdlib\ArrayUtils;

/**
 * Base class for Zend\Navigation\Page pages
 */
abstract class AbstractPage extends \Zend\Navigation\Page\AbstractPage // AbstractContainer  // ToDo extends Zend\Navigation\Page\AbstractPage
{	
    /**
     * Style class for the anchor tag of the page (CSS)
     *
     * @var string|null
     */
    protected $anchorClass;

    // Initialization:

    /**
     * Factory for Zend_Navigation_Page classes
     *
     * A specific type to construct can be specified by specifying the key
     * 'type' in $options. If type is 'uri' or 'mvc', the type will be resolved
     * to Zend_Navigation_Page_Uri or Zend_Navigation_Page_Mvc. Any other value
     * for 'type' will be considered the full name of the class to construct.
     * A valid custom page class must extend Zend_Navigation_Page.
     *
     * If 'type' is not given, the type of page to construct will be determined
     * by the following rules:
     * - If $options contains either of the keys 'action', 'controller',
     *   or 'route', a Zend_Navigation_Page_Mvc page will be created.
     * - If $options contains the key 'uri', a Zend_Navigation_Page_Uri page
     *   will be created.
     *
     * @param  array|Traversable $options  options used for creating page
     * @return AbstractPage  a page instance
     * @throws Exception\InvalidArgumentException if $options is not
     *                                            array/Traversable
     * @throws Exception\InvalidArgumentException if 'type' is specified
     *                                            but class not found
     * @throws Exception\InvalidArgumentException if something goes wrong
     *                                            during instantiation of
     *                                            the page
     * @throws Exception\InvalidArgumentException if 'type' is given, and
     *                                            the specified type does
     *                                            not extend this class
     * @throws Exception\InvalidArgumentException if unable to determine
     *                                            which class to instantiate
     */
    public static function factory($options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (!is_array($options)) {
            throw new Exception\InvalidArgumentException(
                'Invalid argument: $options must be an array or Traversable'
            );
        }

        if (isset($options['type'])) {
            $type = $options['type'];
            if (is_string($type) && !empty($type)) {
                switch (strtolower($type)) {
                    case 'mvc':
                        $type = 'Csn\Zend\Navigation\Page\Mvc';
                        break;
                    case 'uri':
                        $type = 'Csn\Zend\Navigation\Page\Uri';
                        break;
                }

                if (!class_exists($type, true)) {
                    throw new Exception\InvalidArgumentException(
                        'Cannot find class ' . $type
                    );
                }

                $page = new $type($options);
                if (!$page instanceof self) {
                    throw new Exception\InvalidArgumentException(
                        sprintf(
                            'Invalid argument: Detected type "%s", which ' .
                            'is not an instance of Zend\Navigation\Page',
                            $type
                        )
                    );
                }
                return $page;
            }
        }

        $hasUri = isset($options['uri']);
        $hasMvc = isset($options['action']) || isset($options['controller'])
                || isset($options['route']);

        if ($hasMvc) {
            return new Mvc($options);
        } elseif ($hasUri) {
            return new Uri($options);
        } else {
            throw new Exception\InvalidArgumentException(
                'Invalid argument: Unable to determine class to instantiate'
            );
        }
    }
	
    /**
     * Page constructor
     *
     * @param  array|Traversable $options [optional] page options. Default is
     *                                    null, which should set defaults.
     * @throws Exception\InvalidArgumentException if invalid options are given
     */
	 // do I have to override the constructor It will be called anyway
//-    public function __construct($options = null)
//-    {
//-		parent::__construct($options = null);
        /* Do we need it?
		if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        if (is_array($options)) {
            $this->setOptions($options);
        }

        // do custom initialization
        $this->init();
		*/
//-    }

    /**
     * Sets page CSS anchor class Stoyan
     *
     * @param  string|null $class [optional] CSS class to set. Default
     *                            is null, which sets no CSS class.
     * @return AbstractPage fluent interface, returns self
     * @throws Exception\InvalidArgumentException  if not given string or null
     */
    public function setAnchorClass($class = null)
    {
        if (null !== $class && !is_string($class)) {
            throw new \Zend\Navigation\Exception\InvalidArgumentException(
                'Invalid argument: $class must be a string or null'
            );
        }

        $this->anchorClass = $class;
        return $this;
    }

    /**
     * Returns page class (CSS)
     *
     * @return string|null  page's CSS class or null
     */
    public function getAnchorClass()
    {
        return $this->anchorClass;
    }
}
