<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Agency
 *
 * @ORM\Table(name="agency")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\AgencyRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @DoctrineAssert\UniqueEntity(fields={"name"}, message="Agency name must be unique, please choose another name.")
 * @Gedmo\Loggable
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Agency
{

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * 
     * @var integer $id
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $name
     * 
     * @Assert\NotBlank(message = "Name cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Name has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @Gedmo\Versioned
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;

    /**
     * @var string $slogan
     * 
     * @Assert\NotBlank(message = "Slogan cannot be blank!")
     * @Assert\MinLength(limit= 10, message="Slogan must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 50, message="Slogan has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="slogan", type="string", length=50, nullable=false)
     * @Gedmo\Versioned
     */
    protected $slogan;

    /**
     * @var string $description
     * 
     * @Assert\NotBlank(message = "Description cannot be blank!")
     * @Assert\MinLength(limit= 10, message="Description must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 5000, message="Description has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="description", type="text", length=5000, nullable=true)
     * @Gedmo\Versioned
     */
    protected $description;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="account_number", type="string", length=100, nullable=true)
     */
    protected $accountNumber;    

    /**
     * @var string $address1
     * 
     * @Assert\NotBlank(message = "Address line 1 cannot be blank!")
     * @Assert\MinLength(limit= 3, message="Address line 1 must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 254, message="Address line 1 has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="address_1", type="string", length=254, nullable=false)
     * @Gedmo\Versioned
     */
    protected $address1;

    /**
     * @var string $address2
     * 
     * @Assert\MinLength(limit= 3, message="Address line 2 must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 254, message="Address line 2 has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="address_2", type="string", length=254, nullable=true)
     * @Gedmo\Versioned
     */
    protected $address2;

    /**
     * @var string $postalCode
     * 
     * @Assert\NotBlank(message = "Suburb code cannot be blank!")
     * @Assert\Type(type="numeric", message="Suburb code must be numeric")
     * @Assert\MinLength(limit= 4, message="Suburb code must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 6, message="Suburb code has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="suburb_code", type="string", length=6, nullable=false)
     * @Gedmo\Versioned
     */
    protected $suburbCode;
    
    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Postal box cannot be blank!")
     * @Assert\MinLength(limit= 3, message="Postal box must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 50, message="Postal box has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="postal_box", type="string", length=50, nullable=false)
     * @Gedmo\Versioned
     */
    protected $postalBox;

    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Postal Suburb cannot be blank!")
     * @Assert\MinLength(limit= 3, message="Postal Suburb must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 50, message="Postal Suburb has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="suburb", type="string", length=50, nullable=false)
     * @Gedmo\Versioned
     */
    protected $suburb;

    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Postal code cannot be blank!")
     * @Assert\Type(type="numeric", message="Postal code must be numeric")
     * @Assert\MinLength(limit= 4, message="Postal code must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 6, message="Postal code has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="postal_code", type="string", length=6, nullable=false)
     * @Gedmo\Versioned
     */
    protected $postalCode;    

    /**
     * @var string 
     * 
     * @Assert\MaxLength(limit= 30, message="Vat number has a limit of {{ limit }} characters.")
     * 
     * @ORM\Column(name="vat_number", type="string", length=30, nullable=true)
     * @Gedmo\Versioned
     */
    protected $vatNumber;    

    /**
     * @ORM\OneToMany(targetEntity="Vanessa\CoreBundle\Entity\Member", mappedBy="agency")
     */
    protected $managers;

    /**
     * @ORM\OneToMany(targetEntity="Vanessa\CoreBundle\Entity\Artist", mappedBy="agency")
     */
    protected $artists;

    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Contact person cannot be blank!")
     * @Assert\MaxLength(limit= 50, message="Contact person has a limit of {{ limit }} characters.")
     * 
     * @ORM\Column(name="contact_person", type="string", length=50, nullable=false)
     * @Gedmo\Versioned
     */
    protected $contactPerson; 
    
    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Contact number cannot be blank!")
     * @Assert\Type(type="numeric", message="Contact number {{ value }} is not a valid {{ type }} telephone number.")
     * @Assert\MinLength(limit= 10, message="Contact number must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 12, message="Contact number has a limit of {{ limit }} characters.")
     * 
     * @ORM\Column(name="contact_number", type="string", length=15, nullable=false)
     * @Gedmo\Versioned
     */
    protected $contactNumber; 
    
    /**
     * @var Vanessa\CoreBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isDeleted;
    
    /**
     * @var Vanessa\CoreBundle\Entity\AgencyType
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\AgencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agency_type_id", referencedColumnName="id")
     * })
     * 
     */
    protected $agencyType;  

    /**
     * @var datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member", inversedBy="createdAgencies" )
     */
    protected $createdBy;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
        $this->contactPersons = new ArrayCollection();
        $this->artists = new ArrayCollection();
        $this->setIsDeleted(false);
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     */
    public function setAccountNumber()
    {
        $this->accountNumber = 'MG' . str_pad((int) $this->id, 5, "0", STR_PAD_LEFT);
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber = 'MG' . str_pad((int) $this->id, 5, "0", STR_PAD_LEFT);
        ;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return Agency
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string 
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Agency
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Set address1
     *
     * @param string $address1
     * @return Agency
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Agency
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Agency
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Add managers
     *
     * @param Vanessa\CoreBundle\Entity\Member $managers
     * @return Agency
     */
    public function addManager(\Vanessa\CoreBundle\Entity\Member $managers)
    {
        $this->managers[] = $managers;

        return $this;
    }

    /**
     * Remove managers
     *
     * @param Vanessa\CoreBundle\Entity\Member $managers
     */
    public function removeManager(\Vanessa\CoreBundle\Entity\Member $managers)
    {
        $this->managers->removeElement($managers);
    }

    /**
     * Get managers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Agency
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set status
     *
     * @param \Vanessa\CoreBundle\Entity\Status $status
     * @return Agency
     */
    public function setStatus(\Vanessa\CoreBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Vanessa\CoreBundle\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $createdBy
     * @return Agency
     */
    public function setCreatedBy(\Vanessa\CoreBundle\Entity\Member $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Vanessa\CoreBundle\Entity\Member 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function createAcc()
    {
        $this->setAccountNumber('MG' . str_pad((int) $this->id, 5, "0", STR_PAD_LEFT));
    }

    /**
     * Add artists
     *
     * @param \Vanessa\CoreBundle\Entity\Artist $artists
     * @return Agency
     */
    public function addArtist(\Vanessa\CoreBundle\Entity\Artist $artists)
    {
        $this->artists[] = $artists;

        return $this;
    }

    /**
     * Remove artists
     *
     * @param \Vanessa\CoreBundle\Entity\Artist $artists
     */
    public function removeArtist(\Vanessa\CoreBundle\Entity\Artist $artists)
    {
        $this->artists->removeElement($artists);
    }

    /**
     * Get artists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Agency
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Set vatNumber
     *
     * @param string $vatNumber
     * @return Agency
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
    
        return $this;
    }

    /**
     * Get vatNumber
     *
     * @return string 
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * Add contactPersons
     *
     * @param \Vanessa\CoreBundle\Entity\Member $contactPersons
     * @return Agency
     */
    public function addContactPerson(\Vanessa\CoreBundle\Entity\Member $contactPersons)
    {
        $this->contactPersons[] = $contactPersons;
    
        return $this;
    }

    /**
     * Remove contactPersons
     *
     * @param \Vanessa\CoreBundle\Entity\Member $contactPersons
     */
    public function removeContactPerson(\Vanessa\CoreBundle\Entity\Member $contactPersons)
    {
        $this->contactPersons->removeElement($contactPersons);
    }

    /**
     * Get contactPersons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactPersons()
    {
        return $this->contactPersons;
    }

    /**
     * Set suburbCode
     *
     * @param string $suburbCode
     * @return Agency
     */
    public function setSuburbCode($suburbCode)
    {
        $this->suburbCode = $suburbCode;
    
        return $this;
    }

    /**
     * Get suburbCode
     *
     * @return string 
     */
    public function getSuburbCode()
    {
        return $this->suburbCode;
    }

    /**
     * Set postalBox
     *
     * @param string $postalBox
     * @return Agency
     */
    public function setPostalBox($postalBox)
    {
        $this->postalBox = $postalBox;
    
        return $this;
    }

    /**
     * Get postalBox
     *
     * @return string 
     */
    public function getPostalBox()
    {
        return $this->postalBox;
    }

    /**
     * Set suburb
     *
     * @param string $suburb
     * @return Agency
     */
    public function setSuburb($suburb)
    {
        $this->suburb = $suburb;
    
        return $this;
    }

    /**
     * Get suburb
     *
     * @return string 
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * Set contactPerson
     *
     * @param string $contactPerson
     * @return Agency
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
    
        return $this;
    }

    /**
     * Get contactPerson
     *
     * @return string 
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     * @return Agency
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;
    
        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string 
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * Set agencyType
     *
     * @param \Vanessa\CoreBundle\Entity\AgencyType $agencyType
     * @return Agency
     */
    public function setAgencyType(\Vanessa\CoreBundle\Entity\AgencyType $agencyType = null)
    {
        $this->agencyType = $agencyType;
    
        return $this;
    }

    /**
     * Get agencyType
     *
     * @return \Vanessa\CoreBundle\Entity\AgencyType 
     */
    public function getAgencyType()
    {
        return $this->agencyType;
    }
}
