<?php
namespace CsnCms\Entity;

use Doctrine\ORM\Mapping as ORM;
// added by Stoyan
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation; // !!!! Absolutely neccessary

/**
 * Resources
 *
 * @ORM\Table(name="resources")
 * @ORM\Entity(repositoryClass="CsnCms\Entity\Repository\ResourceRepository")
 * @Annotation\Name("resource")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Resource
{
    /**
     * @var string
     *
     * @ORM\Column(name="rs_name", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Resource:"})	 
     */
    private $rsName;


    /**
     * @var integer
     *
     * @ORM\Column(name="rs_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $rsId;

    public function __toString()
	{
		return $this->rsName;
	}	

    /**
     * Set rsName
     *
     * @param string $rsName
     * @return Resource
     */
    public function setRsName($rsName)
    {
        $this->rsName = $rsName;
    
        return $this;
    }

    /**
     * Get rsName
     *
     * @return string 
     */
    public function getRsName()
    {
        return $this->rsName;
    }
	
    /**
     * Get rsId
     *
     * @return integer 
     */
    public function getRsId()
    {
        return $this->rsId;
    }
}