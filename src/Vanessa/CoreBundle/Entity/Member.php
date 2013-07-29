<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Vanessa\CoreBundle\Entity\Member
 *
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\MemberRepository")
 * 
 * @ORM\Table(name="member",
 *      indexes={@ORM\Index(name="search_context", columns={"first_name","last_name","mobile_number"})}
 * )
 * 
 * @DoctrineAssert\UniqueEntity(fields={"email"}, message="Email address is already being used by another user, please try another one.")
 * @ORM\HasLifecycleCallbacks
 *
 * @Gedmo\Loggable
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1 
 * 
 */
class Member implements AdvancedUserInterface, \Serializable
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "First name cannot be blank!")
     * @Assert\MinLength(limit= 2, message="First name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="First name has a limit of {{ limit }} characters.")
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="First Name cannot contain a number"
     *  )
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     * @Gedmo\Versioned
     */
    protected $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Last name cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Last name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Last name has a limit of {{ limit }} characters.")
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="Last Name cannot contain a number"
     *  )
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Gedmo\Versioned
     */
    protected $lastName;
    
    /**
     * @var string $idNumber
     * 
     * @Assert\MinLength(limit= 8, message="Id or Passort number must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Id or Passort number has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="id_number", type="string", length=100, nullable=true)
     * @Gedmo\Versioned
     */
    protected $idNumber;    
    
    /**
     * @Gedmo\Slug(fields={"firstName","lastName"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;    

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Email address cannot be blank!")
     * @Assert\Email(
     *   message = "The email '{{ value }}' is not a valid email.",
     *   checkMX = false
     * )
     * @ORM\Column(name="email", type="string", length=254)
     * @Gedmo\Versioned
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Gedmo\Versioned
     */
    protected $username;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Password cannot be blank!")
     * @Assert\MinLength(limit= 5, message="Password must have at least {{ limit }} characters.")
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Gedmo\Versioned
     */
    protected $password;

    /**
     * @var salt
     *
     * @ORM\Column(name="salt",type="string", length=255)
     */
    protected $salt;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Vanessa\CoreBundle\Entity\Role")
     * @ORM\JoinTable(name="member_role_map",
     *     joinColumns={@ORM\JoinColumn(name="member_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     * 
     */
    protected $memberRoles;

    /**
     * @var string
     *
     * @Assert\MinLength(limit= 10, message="Mobile number must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 20, message="Mobile number has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="mobile_number", type="string", length=20 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $mobileNumber;

    /**
     * @var Status
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
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $group;

    /**
     * @var Title
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Title")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="title_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $title;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Gender")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     * })
     * @Gedmo\Versioned
     */
    protected $gender;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isAdmin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Gedmo\Versioned
     */
    protected $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean")
     * @Gedmo\Versioned
     */
    protected $expired;

    /**
     * @var datetime
     *
     * @ORM\Column(name="last_login", type="datetime" , nullable= true)
     */
    protected $lastLogin;

    /**
     * @var datetime
     *
     * @ORM\Column(name="expires_at", type="datetime" , nullable= true)
     */
    protected $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string" , length=254 ,nullable= true)
     */
    protected $confirmationToken;

    /**
     * @var datetime
     *
     * @ORM\Column(name="password_requested_at", type="datetime" , nullable= true)
     */
    protected $passwordRequestedAt;

    /**
     * @var Vanessa\CoreBundle\Entity\Agency
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Agency", inversedBy="managers")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     * @Gedmo\Versioned
     */
    protected $agency;

    /**
     * @ORM\OneToMany(targetEntity="Vanessa\CoreBundle\Entity\Agency", mappedBy="createdBy" , cascade={"persist", "remove"} )
     */
    protected $createdAgencies = null;

    /**
     * @ORM\OneToMany(targetEntity="Vanessa\CoreBundle\Entity\SongTemp", mappedBy="createdBy" , cascade={"persist", "remove"} )
     */
    protected $uploadSongs = null;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     * @link https://github.com/stof/StofDoctrineExtensionsBundle
     */
    protected $createdAt;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="deleted_at", type="datetime" , nullable=true)
     */
    protected $deletedAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @link https://github.com/stof/StofDoctrineExtensionsBundle
     */
    protected $updatedAt;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member")
     */
    protected $createdBy;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member")
     */
    protected $deletedBy;

    public function __construct()
    {
        $this->isAdmin = false;
        $this->enabled = true;
        $this->expired = false;
        $this->memberRoles = new ArrayCollection();
        $this->createdAgencies = new ArrayCollection();
        $this->uploadSongs = new ArrayCollection();
        $this->setIsDeleted(false);
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {
        
    }

    /**
     * Gets an array of roles.
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getMemberRoles()->toArray();
    }

    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param  UserInterface $user The user
     * @return boolean       True if equal, false othwerwise.
     */
    public function isEqualTo(AdvancedUserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
     * @ORM\PrePersist()
     */
    public function finalizeMember()
    {
        if (null == $this->getUsername()) {
            $this->setUsername($this->getEmail());
        }

        if (null == $this->getExpiresAt()) {
            $date = new \DateTime();
            $this->setExpiresAt($date->modify('+6 months'));
        }
    }

    /**
     * @ORM\PrePersist()
     */
    public function encodePassword()
    {
        //set password encoding
        $this->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($this->getPassword(), $this->getSalt());
        $this->setPassword($password);
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
                $this->id,
            ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
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
     * Concat first and last name
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
    
    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set mobileNumber
     *
     * @param string $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * Get mobileNumber
     *
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
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
     * Set status
     *
     * @param Vanessa\CoreBundle\Entity\Status $status
     */
    public function setStatus(\Vanessa\CoreBundle\Entity\Status $status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return Vanessa\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set title
     *
     * @param Vanessa\CoreBundle\Entity\Title $title
     */
    public function setTitle(\Vanessa\CoreBundle\Entity\Title $title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return Vanessa\CoreBundle\Entity\Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set gender
     *
     * @param Vanessa\CoreBundle\Entity\Gender $gender
     */
    public function setGender(\Vanessa\CoreBundle\Entity\Gender $gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return Vanessa\CoreBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add memberRoles
     *
     * @param Vanessa\CoreBundle\Entity\Role $memberRoles
     */
    public function addEntityRole(\Vanessa\CoreBundle\Entity\Role $memberRoles)
    {
        $this->memberRoles[] = $memberRoles;
    }

    /**
     * Get memberRoles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMemberRoles()
    {
        return $this->memberRoles;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set lastLogin
     *
     * @param datetime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * Get lastLogin
     *
     * @return datetime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set expiresAt
     *
     * @param datetime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Get expiresAt
     *
     * @return datetime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param datetime $passwordRequestedAt
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return datetime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Add memberRoles
     *
     * @param Vanessa\CoreBundle\Entity\Role $memberRoles
     */
    public function addRole(\Vanessa\CoreBundle\Entity\Role $memberRoles)
    {
        $this->memberRoles[] = $memberRoles;
    }

    /**
     * reset memberRoles
     *
     * @param Vanessa\CoreBundle\Entity\Role $memberRoles
     */
    public function resetRoles()
    {
        $this->memberRoles[] = array();
    }

    /**
     * Set group
     *
     * @param Vanessa\CoreBundle\Entity\Group $group
     */
    public function setGroup(\Vanessa\CoreBundle\Entity\Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return Vanessa\CoreBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set agency
     *
     * @param Vanessa\CoreBundle\Entity\agency $agency
     */
    public function setAgency(\Vanessa\CoreBundle\Entity\Agency $agency)
    {
        $this->agency = $agency;
    }

    /**
     * Get agency
     *
     * @return Vanessa\CoreBundle\Entity\Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add memberRoles
     *
     * @param Vanessa\CoreBundle\Entity\Role $memberRoles
     * @return Member
     */
    public function addMemberRole(\Vanessa\CoreBundle\Entity\Role $memberRoles)
    {
        $this->memberRoles[] = $memberRoles;

        return $this;
    }

    /**
     * Remove memberRoles
     *
     * @param Vanessa\CoreBundle\Entity\Role $memberRoles
     */
    public function removeMemberRole(\Vanessa\CoreBundle\Entity\Role $memberRoles)
    {
        $this->memberRoles->removeElement($memberRoles);
    }

    /**
     * Add createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     * @return Member
     */
    public function addCreatedAgencies(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies[] = $createdAgencies;

        return $this;
    }

    /**
     * Remove createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     */
    public function removeCreatedAgencies(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies->removeElement($createdAgencies);
    }

    /**
     * Get createdAgencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedAgencies()
    {
        return $this->createdAgencies;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Member
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
     * Add createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     * @return Member
     */
    public function addCreatedAgencie(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies[] = $createdAgencies;

        return $this;
    }

    /**
     * Remove createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     */
    public function removeCreatedAgencie(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies->removeElement($createdAgencies);
    }

    /**
     * Set createdBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $createdBy
     * @return Member
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
     * Set isAdmin
     *
     * @param boolean $isAdmin
     * @return Member
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Add uploadSongs
     *
     * @param \Vanessa\CoreBundle\Entity\SongTemp $uploadSongs
     * @return Member
     */
    public function addUploadSong(\Vanessa\CoreBundle\Entity\SongTemp $uploadSongs)
    {
        $this->uploadSongs[] = $uploadSongs;

        return $this;
    }

    /**
     * Remove uploadSongs
     *
     * @param \Vanessa\CoreBundle\Entity\SongTemp $uploadSongs
     */
    public function removeUploadSong(\Vanessa\CoreBundle\Entity\SongTemp $uploadSongs)
    {
        $this->uploadSongs->removeElement($uploadSongs);
    }

    /**
     * Get uploadSongs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUploadSongs()
    {
        return $this->uploadSongs;
    }


    /**
     * Add createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     * @return Member
     */
    public function addCreatedAgency(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies[] = $createdAgencies;

        return $this;
    }

    /**
     * Remove createdAgencies
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $createdAgencies
     */
    public function removeCreatedAgency(\Vanessa\CoreBundle\Entity\Agency $createdAgencies)
    {
        $this->createdAgencies->removeElement($createdAgencies);
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Member
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Member
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $deletedBy
     * @return Member
     */
    public function setDeletedBy(\Vanessa\CoreBundle\Entity\Member $deletedBy = null)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return \Vanessa\CoreBundle\Entity\Member 
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * Set idNumber
     *
     * @param string $idNumber
     * @return Member
     */
    public function setIdNumber($idNumber)
    {
        $this->idNumber = $idNumber;

        return $this;
    }

    /**
     * Get idNumber
     *
     * @return string 
     */
    public function getIdNumber()
    {
        return $this->idNumber;
    }
}
