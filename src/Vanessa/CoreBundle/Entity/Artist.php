<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Artist
 *
 * @ORM\Table(name="artist",
 *    indexes={@ORM\Index(name="search_context", columns={"first_name","last_name","middle_name","stage_name"})}
 * )
 * 
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\ArtistRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @DoctrineAssert\UniqueEntity(fields={"stageName"}, message="Stage name must be unique, please choose another name.")
 * @Gedmo\Loggable
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Artist
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\MinLength(limit= 2, message="First name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="First name has a limit of {{ limit }} characters.")
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="First Name cannot contain a number"
     *  )
     *
     * @ORM\Column(name="first_name", type="string", length=100 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $firstName;

    /**
     * @var string
     *
     * @Assert\MinLength(limit= 2, message="Last name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Last name has a limit of {{ limit }} characters.")
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="Last Name cannot contain a number"
     *  )
     *
     * @ORM\Column(name="last_name", type="string", length=100 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $lastName;

    /**
     * @var string
     *
     * @Assert\MinLength(limit= 2, message="Middle name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Middle name has a limit of {{ limit }} characters.")
     * @Assert\Regex(pattern="/\d/",
     *               match=false,
     *               message="Middle Name cannot contain a number"
     *  )
     *
     * @ORM\Column(name="middle_name", type="string", length=100 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $middleName;

    /**
     * @var string 
     * 
     * @Assert\NotBlank(message = "Stage name cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Stage name must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Stage name has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="stage_name", type="string", length=100, nullable=false)
     * @Gedmo\Versioned
     */
    protected $stageName;

    /**
     * @Gedmo\Slug(fields={"stageName"})
     * @ORM\Column(name="slug" , length=150 , unique=true)
     */
    protected $slug;

    /**
     * @var string $shortBiography
     * 
     * @Assert\NotBlank(message = "Biography cannot be blank!")
     * @Assert\MinLength(limit= 10, message="Biography must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit=10000, message="Biography has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="shortBiography", type="text", length=10000, nullable=false)
     * @Gedmo\Versioned
     */
    protected $shortBiography;

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
     * @var Vanessa\CoreBundle\Entity\Agency
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Agency", inversedBy="artists")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     * @Gedmo\Versioned
     */
    protected $agency;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Vanessa\CoreBundle\Entity\Genre")
     * @ORM\JoinTable(name="artist_genre_map",
     *     joinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     * 
     */
    protected $genres;

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
     * @var boolean
     *
     * @ORM\Column(name="is_group", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isGroup;    

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Gedmo\Versioned
     */
    protected $enabled;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @Assert\File(
     * maxSize="3M",
     * maxSizeMessage= "The file is too large ({{ size }}). Allowed maximum size is {{ limit }}",
     * mimeTypes = {"image/jpeg", "image/jpg" , "image/png"},
     * mimeTypesMessage = "Please upload a valid image file, we only support jpeg and png.",
     * uploadErrorMessage = "The file could not be uploaded"
     * )
     */
    public $picture;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="deleted_at", type="datetime" , nullable=true)
     */
    protected $deletedAt;    

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member", inversedBy="createdAgencies" )
     */
    protected $createdBy;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member")
     */
    protected $deletedBy;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->setIsDeleted(false);
        $this->setEnabled(true);
    }

    public function __toString()
    {
        return $this->getStageName();
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

    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Artist
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
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
     * @return Artist
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
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
     * Set stageName
     *
     * @param string $stageName
     * @return Artist
     */
    public function setStageName($stageName)
    {
        $this->stageName = $stageName;

        return $this;
    }

    /**
     * Get stageName
     *
     * @return string 
     */
    public function getStageName()
    {
        return $this->stageName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Artist
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
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Artist
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Artist
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Artist
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set gender
     *
     * @param \Vanessa\CoreBundle\Entity\Gender $gender
     * @return Artist
     */
    public function setGender(\Vanessa\CoreBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \Vanessa\CoreBundle\Entity\Gender 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set agency
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $agency
     * @return Artist
     */
    public function setAgency(\Vanessa\CoreBundle\Entity\Agency $agency = null)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Vanessa\CoreBundle\Entity\Agency 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add genres
     *
     * @param \Vanessa\CoreBundle\Entity\Genre $genres
     * @return Artist
     */
    public function addGenre(\Vanessa\CoreBundle\Entity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param \Vanessa\CoreBundle\Entity\Genre $genres
     */
    public function removeGenre(\Vanessa\CoreBundle\Entity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Set status
     *
     * @param \Vanessa\CoreBundle\Entity\Status $status
     * @return Artist
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
     * @return Artist
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

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/artists';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->picture) {
            $this->path = $this->picture->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->picture) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does

        $this->picture->move($this->getUploadRootDir(), $this->slug .'-'.$this->id.'.' . $this->picture->guessExtension());
        unset($this->picture);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($picture = $this->getAbsolutePath()) {
            unlink($picture);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->slug .'-'.$this->id.'.' . $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Artist
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set shortBiography
     *
     * @param string $shortBiography
     * @return Artist
     */
    public function setShortBiography($shortBiography)
    {
        $this->shortBiography = $shortBiography;

        return $this;
    }

    /**
     * Get shortBiography
     *
     * @return string 
     */
    public function getShortBiography()
    {
        return $this->shortBiography;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     * @return Artist
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string 
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set deletedBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $deletedBy
     * @return Artist
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Artist
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
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
    
    public function getImageName()
    {
        return $this->slug .'-'.$this->id;
    }


    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Artist
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
     * Set isGroup
     *
     * @param boolean $isGroup
     * @return Artist
     */
    public function setIsGroup($isGroup)
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    /**
     * Get isGroup
     *
     * @return boolean 
     */
    public function getIsGroup()
    {
        return $this->isGroup;
    }
}
