<?php

namespace AlbumDm\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity
 * @Annotation\Name("album")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Album
{
    /**
     * @var string
     *
     * @ORM\Column(name="artist", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Artist:"})
     */
    protected $artist;	
	
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Title:"})
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    protected $id;
	
    /**
     * Set Artist
     *
     * @param  string   $artist
     * @return Album
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get Artist
     *
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }	
	
    /**
     * Set Title
     *
     * @param  string   $title
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }	
	
    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }	
}