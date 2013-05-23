<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vanessa\CoreBundle\Entity\MimeType
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\MimeTypeRepository")
 * @ORM\Table(name="mime_type")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class MimeType
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
     * @ORM\Column(name="mime", type="string", length=50)
     */
    protected $mime ;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50)
     */
    protected $description ;    
    
    public function __construct( $mime )
    {
        $this->mime = $mime ;
    }

    public function __toString()
    {
        return $this->mime ;
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
     * Set mime
     *
     * @param string $mime
     */
    public function setMime( $mime )
    {
        $this->mime = $mime ;
    }

    /**
     * Get mime
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime ;
    }
    
    /**
     * Set mime description
     *
     * @param string $description
     */
    public function setDescription( $description )
    {
        $this->description = $description ;
    }

    /**
     * Get mime description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description ;
    }    
    
}
