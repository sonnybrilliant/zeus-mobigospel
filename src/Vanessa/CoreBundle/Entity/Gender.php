<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vanessa\CoreBundle\Entity\Gender
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\GenderRepository")
 * @ORM\Table(name="gender")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Gender
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
     * @ORM\Column(name="name",type="string", length=10)
     */
    protected $name ;

    public function __construct( $name )
    {
        $this->name = $name ;
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

}
