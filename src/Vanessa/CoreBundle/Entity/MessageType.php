<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vanessa\CoreBundle\Entity\MessageType
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\MessageTypeRepository")
 * @ORM\Table(name="message_type")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class MessageType
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
     * @ORM\Column(name="type", type="string", length=50)
     */
    protected $type ;

    public function __construct( $type )
    {
        $this->type = $type ;
    }

    public function __toString()
    {
        return $this->type ;
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
     * Set type
     *
     * @param string $type
     * @return AgencyType
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
