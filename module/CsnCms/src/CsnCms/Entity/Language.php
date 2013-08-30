<?php
namespace CsnCms\Entity;

use Doctrine\ORM\Mapping as ORM;
// added by Stoyan
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation; // !!!! Absolutely neccessary

/**
 * Languages
 *
 * @ORM\Table(name="languages")
 * @ORM\Entity(repositoryClass="CsnCms\Entity\Repository\LanguageRepository")
 * @Annotation\Name("language")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Language
{
    /**
     * @var string
     *
     * @ORM\Column(name="lng_name", type="string", length=50, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Language:"})	 
     */
    private $lngName;

    /**
     * @var string
     *
     * @ORM\Column(name="lng_abbreviation", type="string", length=10, nullable=true)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Abbreviation:"})	 
     */
    private $lngAbbreviation;

    /**
     * @var integer
     *
     * @ORM\Column(name="lng_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $lngId;

    public function __toString()
	{
		return $this->lngName;
	}	
	
    /**
     * Set lngName
     *
     * @param string $lngName
     * @return Language
     */
    public function setLngName($lngName)
    {
        $this->lngName = $lngName;
    
        return $this;
    }
	
    /**
     * Get lngName
     *
     * @return string 
     */
    public function getLngName()
    {
        return $this->lngName;
    }

    /**
     * Set lngAbbreviation
     *
     * @param string $lngAbbreviation
     * @return Language
     */
    public function setLngAbbreviation($lngAbbreviation)
    {
        $this->lngAbbreviation = $lngAbbreviation;
    
        return $this;
    }

    /**
     * Get lngAbbreviation
     *
     * @return string 
     */
    public function getLngAbbreviation()
    {
        return $this->lngAbbreviation;
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
}