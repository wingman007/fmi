<?php
namespace Csn\Zend\View\Helper\Navigation;

// Be careful when remove use statements make sure the classes are not used in the code
use Zend\Navigation\Page\AbstractPage;

/*
RFD http://framework.zend.com/manual/2.2/en/modules/zend.navigation.view.helpers.html

Breadcrumbs, used for rendering the path to the currently active page.
Links, used for rendering navigational head links (e.g. <link rel="next" href="..." />)
Menu, used for rendering menus.
Sitemap, used for rendering sitemaps conforming to the Sitemaps XML format.
Navigation, used for proxying calls to other navigational helpers.

getContainer() and setContainer() gets and sets the navigation container the helper should operate on by default, and hasContainer() checks if the helper has container registered.
__call() is used for proxying calls to the container registered in the helper, which means you can call methods on a helper as if it was a container. See example below.
htmlify() renders an ‘a’ HTML element from a Zend\Navigation\Page\AbstractPage instance.
The static method setDefaultAcl() is used for setting a default ACL object that will be used by helpers.
The static method setDefaultRole() is used for setting a default Role that will be used by helpers
*/

/**
 * Helper for rendering menus from navigation containers
 */
class Menu extends \Zend\View\Helper\Navigation\Menu // AbstractHelper
{
    /**
     * @override htmlify from the parent/base/super class
     */
    public function htmlify(AbstractPage $page, $escapeLabel = true, $addClassToListItem = false)
    {
		// !!! This method will be executed in the namespace of the class
		// !!! But the methods of the super/base class will be executed in its own namespace
        // get label and title for translating
        $label = $page->getLabel();
        $title = $page->getTitle();

        // translate label and title?
        if (null !== ($translator = $this->getTranslator())) {
            $textDomain = $this->getTranslatorTextDomain();
            if (is_string($label) && !empty($label)) {
                $label = $translator->translate($label, $textDomain);
            }
            if (is_string($title) && !empty($title)) {
                $title = $translator->translate($title, $textDomain);
            }
        }

        // get attribs for element
        $attribs = array(
            'id'     => $page->getId(),
            'title'  => $title,
        );

		$attribs['class'] = '';
        if ($addClassToListItem === false) {
            $attribs['class'] = $page->getClass();
        }
		// Stoyan
		$attribs['class'] .= ($attribs['class'])? ' ': '';
		$attribs['class'] .= $page->getAnchorClass();
	
//		echo 'Menu<pre>';
//		echo 'Class: ' . $page->getClass();
//		echo 'Anchor Class: ' . $page->getAnchorClass();
//		print_r($attribs);
//		echo '</pre>';
        // does page have a href?
        $href = $page->getHref();
        if ($href) {
            $element = 'a';
            $attribs['href'] = $href;
            $attribs['target'] = $page->getTarget();
        } else {
            $element = 'span';
        }

        $html = '<' . $element . $this->htmlAttribs($attribs) . '>';
        if ($escapeLabel === true) {
            $escaper = $this->view->plugin('escapeHtml');
            $html .= $escaper($label);
        } else {
            $html .= $label;
        }
        $html .= '</' . $element . '>';

        return $html;
    }
}

/*
http://framework.zend.com/manual/2.2/en/modules/zend.navigation.view.helpers.html
here are 5 built-in helpers:

Breadcrumbs, used for rendering the path to the currently active page.
Links, used for rendering navigational head links (e.g. <link rel="next" href="..." />)
Menu, used for rendering menus.
Sitemap, used for rendering sitemaps conforming to the Sitemaps XML format.
Navigation, used for proxying calls to other navigational helpers.
All built-in helpers extend Zend\View\Helper\Navigation\AbstractHelper, which adds integration with ACL and translation. The abstract class implements the interface Zend\View\Helper\Navigation\HelperInterface, which defines the following methods:

getContainer() and setContainer() gets and sets the navigation container the helper should operate on by default, and hasContainer() checks if the helper has container registered.
getTranslator() and setTranslator() gets and sets the translator used for translating labels and titles. getUseTranslator() and setUseTranslator() controls whether the translator should be enabled. The method hasTranslator() checks if the helper has a translator registered.
getAcl(), setAcl(), getRole() and setRole(), gets and sets ACL (Zend\Permissions\Acl\AclInterface) instance and role (String or Zend\Permissions\Acl\Role\RoleInterface) used for filtering out pages when rendering. getUseAcl() and setUseAcl() controls whether ACL should be enabled. The methods hasAcl() and hasRole() checks if the helper has an ACL instance or a role registered.
__toString(), magic method to ensure that helpers can be rendered by echoing the helper instance directly.
render(), must be implemented by concrete helpers to do the actual rendering.
*/
