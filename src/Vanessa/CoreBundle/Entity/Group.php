<?php

namespace Vanessa\CoreBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\RoleInterface ;

/**
 * Vanessa\CoreBundle\Entity\Group
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\GroupRepository")
 * @ORM\Table(name="member_groups")
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Group
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
     * @ORM\Column(name="name", type="string",length=100)
     */
    protected $name ;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Vanessa\CoreBundle\Entity\Role")
     * @ORM\JoinTable(name="group_role_map",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles ;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string",length=254)
     */
    protected $description ;

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

    /**
     * Add roles
     *
     * @param Vanessa\CoreBundle\Entity\Role $roles
     */
    public function addRole( \Vanessa\CoreBundle\Entity\Role $roles )
    {
        $this->roles[] = $roles ;
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles ;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Remove roles
     *
     * @param Vanessa\CoreBundle\Entity\Role $roles
     */
    public function removeRole(\Vanessa\CoreBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
}
