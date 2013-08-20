<?php

namespace CsnCms\Entity; // added by Stoyan
// If somethign doesn't work after git merge copy the Articles from the key drive or another working copy of the file
use Doctrine\ORM\Mapping as ORM;
// added by Stoyan
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation; // !!!! Absolutely neccessary

// SUPER important is to remove      @ORM\Column(name="rl_id", type="integer", nullable=true) from the role in order to make it work
// http://stackoverflow.com/questions/6899335/doctrine-class-has-no-association-named
// setters and getters - Zend\Stdlib\Hydrator\ClassMethods, for public properties - Zend\Stdlib\Hydrator\ObjectProperty, array 
// Zend\Stdlib\Hydrator\ArraySerializable
// Follows the definition of ArrayObject. 
// Objects must implement either the exchangeArray() or populate() methods to support hydration, 
// and the getArrayCopy() method to support extraction.
// https://bitbucket.org/todor_velichkov/homeworkuniversity/src/935b37b87e3f211a72ee571142571089dffbf82d/module/University/src/University/Form/StudentForm.php?at=master

// read here http://framework.zend.com/manual/2.1/en/modules/zend.form.quick-start.html

// children - are the transaltions
// parent - is the original article

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="CsnCms\Entity\Repository\ArticleRepository")
 * @Annotation\Name("article")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Article
{
	/**
     * @ORM\OneToMany(targetEntity="CsnCms\Entity\Article", mappedBy="parent")
	 * @Annotation\Exclude()
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="CsnCms\Entity\Article", inversedBy="children")
     * @ORM\JoinColumn(name="artc_parent_id", referencedColumnName="artc_id")
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Required(false)
	 * @Annotation\Options({
	 * "label":"Original Article:",
	 * "empty_option": "Please, choose the Original Article",
	 * "target_class":"CsnCms\Entity\Article",
	 * "property": "artcTitle"})
     **/
    private $parent = null;
	
    /**
     * @var CsnCms\Entity\Language
     *
	 * @ORM\ManyToOne(targetEntity="CsnCms\Entity\Language")
	 * @ORM\JoinColumn(name="lng_id", referencedColumnName="lng_id")
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Options({
	 * "label":"Language:",
	 * "empty_option": "Please, choose your language",
	 * "target_class":"CsnCms\Entity\Language",
	 * "property": "lngName"})
     */
    private $language;

    /**
     * @var AuthDoctrine\Entity\User
     *
	 * @ORM\ManyToOne(targetEntity="AuthDoctrine\Entity\User")
	 * @ORM\JoinColumn(name="usr_id", referencedColumnName="usr_id")
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Options({
	 * "label":"Author:",
	 * "empty_option": "Please, choose the Author",
	 * "target_class":"AuthDoctrine\Entity\User",
	 * "property": "usrName"})
     */
    private $author;
	
    /**
     * @var CsnCms\Entity\Resource
     *
	 * @ORM\ManyToOne(targetEntity="CsnCms\Entity\Resource")
	 * @ORM\JoinColumn(name="rs_id", referencedColumnName="rs_id")
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Options({
	 * "label":"Resource:",
	 * "empty_option": "Please, choose the Resource",
	 * "target_class":"CsnCms\Entity\Resource",
	 * "property": "rsName"})
     */
    private $resource;
	
    /**
     * @var string
     *
     * @ORM\Column(name="artc_title", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Title:"})	 
     */
    private $artcTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="artc_slug", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Slug:"})	 
     */
    private $artcSlug;
	
    /**
     * @var string
     *
     * @ORM\Column(name="artc_introtext", type="text", nullable=true)
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Intro Text:"})	 
     */
    private $artcIntrotext;
	
    /**
     * @var string
     *
     * @ORM\Column(name="artc_fulltext", type="text", nullable=true)
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Full Text:"})	 
     */
    private $artcFulltext;
	
    /**
     * @var DateTime
     *
     * @ORM\Column(name="artc_created", type="datetime", nullable=true)
     * @Annotation\Attributes({"type":"Zend\Form\Element\DateTime", "id": "artcCreated", "min":"2010-01-01T00:00:00Z", "max":"2020-01-01T00:00:00Z", "step":"1"})
     * @Annotation\Options({"label":"Date\Time:", "format":"Y-m-d\TH:iP"})	 
     */ 
    private $artcCreated;

    /**
     * @var CsnCms\Entity\Category
     *
	 * @ORM\ManyToMany(targetEntity="CsnCms\Entity\Category", inversedBy="articles")
     * @ORM\JoinTable(name="articles_categories",
     *      joinColumns={@ORM\JoinColumn(name="artc_id", referencedColumnName="artc_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ctgr_id", referencedColumnName="ctgr_id")}
     *      )
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Attributes({"multiple":true})
	 * @Annotation\Options({
	 * "label":"Categories:",
	 * "empty_option": "Please, choose the categories",
	 * "target_class":"CsnCms\Entity\Category",
	 * "property": "ctgrName"})
     */
    private $categories;

    /**
     * @var Comment[]
     *
	 * @ORM\OneToMany(targetEntity="CsnCms\Entity\Comment", mappedBy="article")
	 * @Annotation\Exclude()
     */
    private $comments;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="artc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $artcId;

    public function __construct() {
        $this->children = new ArrayCollection; // \Doctrine\Common\Collections\ArrayCollection();
		$this->categories = new ArrayCollection;
		$this->comments = new ArrayCollection;
		$this->artcCreated = new \DateTime();
    }
	
    /**
     * Set language
     *
     * @param CsnCms\Entity\Language $language
     * @return Article
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return CsnCms\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set author
     *
     * @param AuthDoctrine\Entity\User $author
     * @return CsnCms\Entity\Article
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return AuthDoctrine\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }	

    /**
     * Set resource
     *
     * @param CsnCms\Entity\Resource $resource
     * @return CsnCms\Entity\Article
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    
        return $this;
    }

    /**
     * Get resource
     *
     * @return CsnCms\Entity\Resource 
     */
    public function getResource()
    {
        return $this->resource;
    }
	
    /**
     * Get artcTitle
     *
     * @return string 
     */
    public function getArtcTitle()
    {
        return $this->artcTitle;
    }

    /**
     * Set artcTitle
     *
     * @param string $artcTitle
     * @return Article
     */
    public function setArtcTitle($artcTitle)
    {
        $this->artcTitle = $artcTitle;
    
        return $this;
    }

    /**
     * Get artcSlug
     *
     * @return string 
     */
    public function getArtcSlug()
    {
        return $this->artcSlug;
    }

    /**
     * Set artcSlug
     *
     * @param string $artcSlug
     * @return Article
     */
    public function setArtcSlug($artcSlug)
    {
        $this->artcSlug = $artcSlug;
    
        return $this;
    }

    /**
     * Get artcIntrotext
     *
     * @return string 
     */
    public function getArtcIntrotext()
    {
        return $this->artcIntrotext;
    }

    /**
     * Set artcIntrotext
     *
     * @param string $artcIntrotext
     * @return Article
     */
    public function setArtcIntrotext($artcIntrotext)
    {
        $this->artcIntrotext = $artcIntrotext;
    
        return $this;
    }

    /**
     * Get artcFulltext
     *
     * @return string 
     */
    public function getArtcFulltext()
    {
        return $this->artcFulltext;
    }

    /**
     * Set artcFulltext
     *
     * @param string $artcFulltext
     * @return Article
     */
    public function setArtcFulltext($artcFulltext)
    {
        $this->artcFulltext = $artcFulltext;
    
        return $this;
    }

    /**
     * Get artcCreated
     *
     * @return DateTime 
     */
    public function getArtcCreated()
    {
        return $this->artcCreated;
    }

    /**
     * Set artcCreated
     *
     * @param DateTime $artcCreated
     * @return Article
     */
    public function setArtcCreated($artcCreated)
    {
        $this->artcCreated = $artcCreated;
    
        return $this;
    }

    /**
     * Get categories
     *
     * @return Array
     */
    public function getCategories()
    {
		return $this->categories;
    }

    /**
     * Set categories
     *
     * @param array $categories
     * @return Article
     */
    public function setCategories($categories)
    {
		$this->categories = $categories; // NOT neccessary
    
        return $this;
    }
	
    /**
     * Add Catgories
     *
     * @param Collection $categories
     * @return Article
     */
    public function addCategories(Collection $categories)
	{
		foreach ($categories as $category) {
			$this->addCategory($category);
		}
		
		return $this;
	}

    /**
     * Add Catgory
     *
     * @param CsnCms\Entity\Category $category
     * @return Article
     */
	public function addCategory(\CsnCms\Entity\Category $category)
	{
		$category->addArticle($this); // synchronously updating inverse side
		$this->categories[] = $category;
		
		return $this;
	}
	
    /**
     * Remove Categories
     *
     * @param DateTime $artcCreated
     * @return Article
     */
    public function removeCategories(Collection $categories)
	{
		foreach ($categories as $category) {
			$this->removeCategory($category);
		}		
	
		return $this;
	}
	
    /**
     * Remove Category
     *
     * @param DateTime $artcCreated
     * @return Article
     */
	public function removeCategory(\CsnCms\Entity\Category $category)
	{
		$this->categories->removeElement($category);
		$category->removeArticle($this); // update the other site
		return $this;
	}

    /**
     * Get children
     *
     * @return Array
     */
    public function getChildren()
    {
		return $this->children;
    }

    /**
     * Set children
     *
     * @param array $children
     * @return Article
     */
    public function setChildren($children)
    {
		$this->children = $children; // NOT neccessary
    
        return $this;
    }

    /**
     * Add Child - translation
     *
     * @param CsnCms\Entity\Article $article
     * @return Article
     */
    public function addChildren(Collection $children)
	{
		foreach ($children as $child) {
			$this->addChild($child);
		}
		
		return $this;
	}

    /**
     * Add Child
     *
     * @param CsnCms\Entity\Article $child
     * @return Article
     */
	public function addChild(\CsnCms\Entity\Article $child)
	{
		$child->setParent($this); // synchronously updating inverse side
		$this->children[] = $child;
		
		return $this;
	}
	
    /**
     * Remove Children
     *
     * @param Collection $children
     * @return Article
     */
    public function removeChildren(Collection $children)
	{
		foreach ($children as $child) {
			$this->removeChild($child);
		}		
	
		return $this;
	}
	
    /**
     * Remove Child
     *
     * @param \CsnCms\Entity\Article $child
     * @return Article
     */
	public function removeChild(\CsnCms\Entity\Article $child)
	{
		$this->children->removeElement($child);
		$child->removeParent($this); // update the other site
		return $this;
	}

    /**
     * Get parent
     *
     * @return \CsnCms\Entity\Article
     */
    public function getParent()
    {
		return $this->parent;
    }

    /**
     * Set parent
     *
     * @param \CsnCms\Entity\Article $parent
     * @return Article
     */
    public function setParent($parent) //can be null in this case
    {
		//    public function setParent(\CsnCms\Entity\Article $parent) doesn't work with null parent
		$this->parent = $parent;
		// if ($parent) $parent->addChild($this); // Max nested functions update the inverse site
        return $this;
    }	

    /**
     * Remove parent
     *
     * @return Article
     */
    public function removeParent(\CsnCms\Entity\Article $parent)
    {
		$this->parent = null; 
		// $this->parent->removeElement($parent);
		// $parent->removeChild($this); // update othe site
	
        return $this;
    }	

    /**
     * Get comments
     *
     * @return Comment[]
     */
    public function getComments()
    {
		return $this->comments;
    }
	
    /**
     * Get artcId
     *
     * @return integer 
     */
    public function getArtcId()
    {
        return $this->artcId;
    }
}