<?php

namespace Fmi\Entity; // added by Stoyan

use Doctrine\ORM\Mapping as ORM;
// added by Stoyan
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation; // !!!! Absolutely neccessary

// setters and getters - Zend\Stdlib\Hydrator\ClassMethods, for public properties - Zend\Stdlib\Hydrator\ObjectProperty, array 
// Zend\Stdlib\Hydrator\ArraySerializable
// Follows the definition of ArrayObject. 
// Objects must implement either the exchangeArray() or populate() methods to support hydration, 
// and the getArrayCopy() method to support extraction.
// https://bitbucket.org/todor_velichkov/homeworkuniversity/src/935b37b87e3f211a72ee571142571089dffbf82d/module/University/src/University/Form/StudentForm.php?at=master

// read here http://framework.zend.com/manual/2.1/en/modules/zend.form.quick-start.html

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Fmi\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="usr_name", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Username:"})	 
     */
    private $usrName;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password", type="string", length=100, nullable=false)
     * @Annotation\Attributes({"type":"password"})
     * @Annotation\Options({"label":"Password:"})	
     */
    private $usrPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_email", type="string", length=60, nullable=false)
	 * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Your email address:"})
     */
    private $usrEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="usrl_id", type="integer", nullable=true)
	 * @ORM\OneToMany(targetEntity="user_riles")
	 * @ORM\JoinColumn(name="usrl_id", referencedColumnName="usrl_id")
	 * @Annotation\Type("Zend\Form\Element\Select")
	 * @Annotation\Options({
	 * "label":"User Role:",
	 * "value_options":{ "0":"Select Role", "1":"Public", "2": "Member"}})
     */
    private $usrlId;

    /**
     * @var integer
     *
     * @ORM\Column(name="lng_id", type="integer", nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Language Id:"})
     */
    private $lngId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usr_active", type="boolean", nullable=false)
	 * @Annotation\Type("Zend\Form\Element\Radio")
	 * @Annotation\Options({
	 * "label":"User Active:",
	 * "value_options":{"1":"Yes", "0":"No"}})
     */
    private $usrActive;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_question", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Question:"})
     */
    private $usrQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_answer", type="string", length=100, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Answer:"})
     */
    private $usrAnswer;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_picture", type="string", length=255, nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"User Picture:"})
     */
    private $usrPicture;

    /**
     * @var integer
     *
     * @ORM\Column(name="usr_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $usrId;


    /**
     * Set usrName
     *
     * @param string $usrName
     * @return Users
     */
    public function setUsrName($usrName)
    {
        $this->usrName = $usrName;
    
        return $this;
    }

    /**
     * Get usrName
     *
     * @return string 
     */
    public function getUsrName()
    {
        return $this->usrName;
    }

    /**
     * Set usrPassword
     *
     * @param string $usrPassword
     * @return Users
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usrPassword = $usrPassword;
    
        return $this;
    }

    /**
     * Get usrPassword
     *
     * @return string 
     */
    public function getUsrPassword()
    {
        return $this->usrPassword;
    }

    /**
     * Set usrEmail
     *
     * @param string $usrEmail
     * @return Users
     */
    public function setUsrEmail($usrEmail)
    {
        $this->usrEmail = $usrEmail;
    
        return $this;
    }

    /**
     * Get usrEmail
     *
     * @return string 
     */
    public function getUsrEmail()
    {
        return $this->usrEmail;
    }

    /**
     * Set usrlId
     *
     * @param integer $usrlId
     * @return Users
     */
    public function setUsrlId($usrlId)
    {
        $this->usrlId = $usrlId;
    
        return $this;
    }

    /**
     * Get usrlId
     *
     * @return integer 
     */
    public function getUsrlId()
    {
        return $this->usrlId;
    }

    /**
     * Set lngId
     *
     * @param integer $lngId
     * @return Users
     */
    public function setLngId($lngId)
    {
        $this->lngId = $lngId;
    
        return $this;
    }

    /**
     * Get lngId
     *
     * @return integer 
     */
    public function getLngId()
    {
        return $this->lngId;
    }

    /**
     * Set usrActive
     *
     * @param boolean $usrActive
     * @return Users
     */
    public function setUsrActive($usrActive)
    {
        $this->usrActive = $usrActive;
    
        return $this;
    }

    /**
     * Get usrActive
     *
     * @return boolean 
     */
    public function getUsrActive()
    {
        return $this->usrActive;
    }

    /**
     * Set usrQuestion
     *
     * @param string $usrQuestion
     * @return Users
     */
    public function setUsrQuestion($usrQuestion)
    {
        $this->usrQuestion = $usrQuestion;
    
        return $this;
    }

    /**
     * Get usrQuestion
     *
     * @return string 
     */
    public function getUsrQuestion()
    {
        return $this->usrQuestion;
    }

    /**
     * Set usrAnswer
     *
     * @param string $usrAnswer
     * @return Users
     */
    public function setUsrAnswer($usrAnswer)
    {
        $this->usrAnswer = $usrAnswer;
    
        return $this;
    }

    /**
     * Get usrAnswer
     *
     * @return string 
     */
    public function getUsrAnswer()
    {
        return $this->usrAnswer;
    }

    /**
     * Set usrPicture
     *
     * @param string $usrPicture
     * @return Users
     */
    public function setUsrPicture($usrPicture)
    {
        $this->usrPicture = $usrPicture;
    
        return $this;
    }

    /**
     * Get usrPicture
     *
     * @return string 
     */
    public function getUsrPicture()
    {
        return $this->usrPicture;
    }

    /**
     * Get usrId
     *
     * @return integer 
     */
    public function getUsrId()
    {
        return $this->usrId;
    }
}

/*
Using Annotations¶
Creating a complete forms solution can often be tedious: you’ll create some domain model object, an input filter for validating it, a form object for providing a representation for it, and potentially a hydrator for mapping the form elements and fieldsets to the domain model. Wouldn’t it be nice to have a central place to define all of these?

Annotations allow us to solve this problem. You can define the following behaviors with the shipped annotations in Zend\Form:

AllowEmpty: mark an input as allowing an empty value. This annotation does not require a value.
Attributes: specify the form, fieldset, or element attributes. This annotation requires an associative array of values, in a JSON object format: @Attributes({"class":"zend_form","type":"text"}).
ComposedObject: specify another object with annotations to parse. Typically, this is used if a property references another object, which will then be added to your form as an additional fieldset. Expects a string value indicating the class for the object being composed.
ErrorMessage: specify the error message to return for an element in the case of a failed validation. Expects a string value.
Exclude: mark a property to exclude from the form or fieldset. This annotation does not require a value.
Filter: provide a specification for a filter to use on a given element. Expects an associative array of values, with a “name” key pointing to a string filter name, and an “options” key pointing to an associative array of filter options for the constructor: @Filter({"name": "Boolean", "options": {"casting":true}}). This annotation may be specified multiple times.
Flags: flags to pass to the fieldset or form composing an element or fieldset; these are usually used to specify the name or priority. The annotation expects an associative array: @Flags({"priority": 100}).
Hydrator: specify the hydrator class to use for this given form or fieldset. A string value is expected.
InputFilter: specify the input filter class to use for this given form or fieldset. A string value is expected.
Input: specify the input class to use for this given element. A string value is expected.
Name: specify the name of the current element, fieldset, or form. A string value is expected.
Options: options to pass to the fieldset or form that are used to inform behavior – things that are not attributes; e.g. labels, CAPTCHA adapters, etc. The annotation expects an associative array: @Options({"label": "Username:"}).
Required: indicate whether an element is required. A boolean value is expected. By default, all elements are required, so this annotation is mainly present to allow disabling a requirement.
Type: indicate the class to use for the current element, fieldset, or form. A string value is expected.
Validator: provide a specification for a validator to use on a given element. Expects an associative array of values, with a “name” key pointing to a string validator name, and an “options” key pointing to an associative array of validator options for the constructor: @Validator({"name": "StringLength", "options": {"min":3, "max": 25}}). This annotation may be specified multiple times.
To use annotations, you simply include them in your class and/or property docblocks. Annotation names will be resolved according to the import statements in your class; as such, you can make them as long or as short as you want depending on what you import.

Note

Form annotations require Doctrine\Common, which contains an annotation parsering engine. The simplest way to install Doctrine\Common is if you are using Composer; simply update your composer.json and add the following line to the require section:

"doctrine/common": ">=2.1",
Then run php composer.phar update to install the dependency.

If you’re not using Composer, visit the Doctrine project website for more details on installation.

// * @ORM\Table(name="users")
// * @ORM\Entity
// * @Annotation\Name("users")
// * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")

// * @ORM\Table(name="users")
// * @ORM\Entity(repositoryClass="Fmi\Entity\Repository\UserRepository")
// * @Annotation\Name("user")
// * @Annotation\Hydrator("DoctrineModule\Stdlib\Hydrator\DoctrineObject")

*/