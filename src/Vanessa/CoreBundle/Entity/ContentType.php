<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vanessa\CoreBundle\Entity\ContentType
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\ContentTypeRepository")
 * @ORM\Table(name="content_type")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class ContentType
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    protected $id ;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name ;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="integer", length=1)
     */
    protected $code ;
    

    public function __construct( $name , $code )
    {
        $this->name = $name ;
        $this->code = $code;
    }

    public function __toString()
    {
        return $this->name ;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id ;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name ;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name ;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode( $code )
    {
        $this->code = $code ;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code ;
    }

}
