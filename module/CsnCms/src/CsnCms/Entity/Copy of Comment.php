<?php

namespace CsnCms\Entity; // added by Stoyan

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
 * Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="CsnCms\Entity\Repository\CommentRepository")
 * @Annotation\Name("comment")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Comment
{	
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
     * @var CsnCms\Entity\Article
     *
	 * @ORM\ManyToOne(targetEntity="CsnCms\Entity\Article", inversedBy="comments")
	 * @ORM\JoinColumn(name="artc_id", referencedColumnName="artc_id")
	 * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
	 * @Annotation\Options({
	 * "label":"Article:",
	 * "empty_option": "Please, choose the Article",
	 * "target_class":"CsnCms\Entity\Article",
	 * "property": "artcTitle"})
     */
    private $article;
	
    /**
     * @var string
     *
     * @ORM\Column(name="com_title", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Title:"})	 
     */
    private $comTitle;
	
    /**
     * @var string
     *
     * @ORM\Column(name="com_text", type="text", nullable=true)
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Text:"})	 
     */
    private $comText;
	
    /**
     * @var DateTime
     *
     * @ORM\Column(name="com_created", type="datetime", nullable=true)
     * @Annotation\Attributes({"type":"Zend\Form\Element\DateTime", "min":"2010-01-01T00:00:00Z", "max":"2020-01-01T00:00:00Z", "step":"1"})
     * @Annotation\Options({"label":"Date\Time:", "format":"Y-m-d\TH:iP"})	 
     */
    private $comCreated;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="com_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $comId;

    public function __construct() {
		$this->comCreated = new \DateTime();
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
     * @return CsnCms\Entity\Comment
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
     * Set article
     *
     * @param CsnCms\Entity\Article $article
     * @return CsnCms\Entity\Comment
     */
    public function setArticle($article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return CsnCms\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }	
	
    /**
     * Get comTitle
     *
     * @return string 
     */
    public function getComTitle()
    {
        return $this->comTitle;
    }

    /**
     * Set comTitle
     *
     * @param string $comTitle
     * @return Article
     */
    public function setComTitle($comTitle)
    {
        $this->comTitle = $comTitle;
    
        return $this;
    }

    /**
     * Get comText
     *
     * @return string 
     */
    public function getComText()
    {
        return $this->comText;
    }

    /**
     * Set comText
     *
     * @param string $comText
     * @return Comment
     */
    public function setComText($comText)
    {
        $this->comText = $comText;
    
        return $this;
    }

    /**
     * Get comCreated
     *
     * @return DateTime 
     */
    public function getComCreated()
    {
        return $this->comCreated;
    }

    /**
     * Set comCreated
     *
     * @param DateTime $comCreated
     * @return Comment
     */
    public function setComCreated($comCreated)
    {
        $this->comCreated = $comCreated;
    
        return $this;
    }
	
    /**
     * Get comId
     *
     * @return integer 
     */
    public function getComId()
    {
        return $this->comId;
    }
}

/*
@var CsnCms\Entity\Article

 @ORM\ManyToOne(targetEntity="CsnCms\Entity\Article") - Unidirectional
*/