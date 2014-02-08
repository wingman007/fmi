<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Csn\Zend\Navigation;

use Countable;
use RecursiveIterator;
use RecursiveIteratorIterator;
use Traversable;
use Zend\Stdlib\ErrorHandler;

// use Zend\Navigation\AbstractContainer as ZendAbstractContainer;

/**
 * Zend_Navigation_Container
 *
 * AbstractContainer class for Zend\Navigation\Page classes.
 */
// abstract class AbstractContainer implements Countable, RecursiveIterator
// abstract class AbstractContainer extends  ZendAbstractContainer // \Zend\Navigation\AbstractContainer
abstract class AbstractContainer extends \Zend\Navigation\AbstractContainer
{
    /**
     * @override to use myAbstractPage Adds a page to the container
     *
     * This method will inject the container as the given page's parent by
     * calling {@link Page\AbstractPage::setParent()}.
     *
     * @param  Page\AbstractPage|array|Traversable $page  page to add
     * @return AbstractContainer fluent interface, returns self
     * @throws Exception\InvalidArgumentException if page is invalid
     */
    public function addPage($page)
    {
        if ($page === $this) {
            throw new \Zend\Navigation\Exception\InvalidArgumentException(
                'A page cannot have itself as a parent'
            );
        }

        if (!$page instanceof Page\AbstractPage) {
            if (!is_array($page) && !$page instanceof Traversable) {
                throw new \Zend\Navigation\Exception\InvalidArgumentException(
                    'Invalid argument: $page must be an instance of '
                    . 'Csn\Zend\Navigation\Page\AbstractPage or Traversable, or an array'
                );
            }
			// Stoyan hard coded I have no choice but to replace it
            $page = Page\AbstractPage::factory($page);
        }

        $hash = $page->hashCode();

        if (array_key_exists($hash, $this->index)) {
            // page is already in container
            return $this;
        }

        // adds page to container and sets dirty flag
        $this->pages[$hash] = $page;
        $this->index[$hash] = $page->getOrder();
        $this->dirtyIndex = true;

        // inject self as page parent
        $page->setParent($this);

        return $this;
    }

    /**
     * @override to use our AbstractPage Removes the given page from the container
     *
     * @param  Page\AbstractPage|int $page page to remove, either a page
     *                                     instance or a specific page order
     * @return bool whether the removal was successful
     */
    public function removePage($page)
    {
		// stoyan
        if ($page instanceof Page\AbstractPage) {
            $hash = $page->hashCode();
        } elseif (is_int($page)) {
            $this->sort();
            if (!$hash = array_search($page, $this->index)) {
                return false;
            }
        } else {
            return false;
        }

        if (isset($this->pages[$hash])) {
            unset($this->pages[$hash]);
            unset($this->index[$hash]);
            $this->dirtyIndex = true;
            return true;
        }

        return false;
    }

	
    /**
     * Checks if the container has the given page
     *
     * @param  Page\AbstractPage $page page to look for
     * @param  bool $recursive [optional] whether to search recursively.
     *                         Default is false.
     * @return bool whether page is in container
     */
	 // stoyan
	 // If I comment and let the super/base class to take care it is asking for Zend\Navigation\Page\AbstractPage
 	// Catchable fatal error: Argument 1 passed to Zend\Navigation\AbstractContainer::hasPage() must be an instance of Zend\Navigation\Page\AbstractPage, instance of Csn\Zend\Navigation\Page\Mvc given, called in F:\PortableApps\PortableGit\projects\grd\vendor\Csn\Zend\Navigation\Page\AbstractPage.php on line 908 and defined in F:\PortableApps\PortableGit\projects\grd\vendor\zendframework\zendframework\library\Zend\Navigation\AbstractContainer.php on line 243
	// Another words this class is in its namespace in Cms the parent is in its namespace Zend
	// the signature is different  but PHP doesn't make difference
	// !!!!!! the method is execured in the namespace where it was declared and defined in this case in Csn not Zend. If I don't have it 
//-	public function hasPage(Page\AbstractPage $page, $recursive = false) // I get a warning here the method is the same but the arguments are different type mine is Csn I am doing overloading here the function with the same name but different parameters while what I want is overriding
	// In order to make it work I will inherit \Zend\Navigation\Page\AbstractPage in my Abstarct Page
/*
	public function hasPage(\Zend\Navigation\Page\AbstractPage $page, $recursive = false)
    {
        if (array_key_exists($page->hashCode(), $this->index)) {
            return true;
        } elseif ($recursive) {
            foreach ($this->pages as $childPage) {
                if ($childPage->hasPage($page, true)) {
                    return true;
                }
            }
        }

        return false;
    }
*/	

}
