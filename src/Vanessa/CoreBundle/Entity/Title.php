<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vanessa\CoreBundle\Entity\Title
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\TitleRepository")
 * @ORM\Table(name="title")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Title
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
    protected $title ;

    public function __construct( $title )
    {
        $this->title = $title ;
    }

    public function __toString()
    {
        return $this->title ;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle( $title )
    {
        $this->title = $title ;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title ;
    }

}
