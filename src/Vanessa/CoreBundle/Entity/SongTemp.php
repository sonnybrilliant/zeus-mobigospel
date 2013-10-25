<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\SongTemp
 *
 * @ORM\Table(name="song_temp",
 *      indexes={@ORM\Index(name="search_context", columns={"title","featured_artist"})}
 * )
 * 
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\SongTempRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @Gedmo\Loggable
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class SongTemp
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
     * @Assert\NotBlank(message = "Song title cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Song title must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Song title has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="title", type="string", length=100)
     * @Gedmo\Versioned
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug" , length=150)
     * 
     */
    protected $slug;  
    
    /**
     * @var string
     *
     * @Assert\MinLength(limit= 2, message="Song ISRC must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 10, message="Song ISRC has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="isrc", type="string", length=11 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $isrc;     

    /**
     * @var string
     *
     * @Assert\MinLength(limit= 2, message="Featured artist must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Featured artist has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="featured_artist", type="string", length=100 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $featuredArtist;      
    
    /**
     * @var Vanessa\CoreBundle\Entity\Agency
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Agency")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     */
    protected $agency;

    /**
     * @var Vanessa\CoreBundle\Entity\Artist
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    protected $artist;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Vanessa\CoreBundle\Entity\Genre")
     * @ORM\JoinTable(name="song_temp_genre_map",
     *     joinColumns={@ORM\JoinColumn(name="song_temp_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */
    protected $genres;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    protected $status;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isActive = true; 

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isDeleted = false;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_preview_version_done", type="boolean", nullable=true)
     * @Gedmo\Versioned
     */
    protected $isPreviewVersionDone;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_full_version_done", type="boolean", nullable=true)
     * @Gedmo\Versioned
     */
    protected $isFullVersionDone;

    /**
     * @var string
     *
     * @ORM\Column(name="full_version", type="string", length=255 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $fullVersion;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="preview_version", type="string", length=255 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $previewVersion;      
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @var string $song
     * 
     * @Assert\File(
     *  maxSize = "25M",
     *  maxSizeMessage = "The file is too large ({{ size }}). Allowed maximum size is {{ limit }} Mega bytes",
     *  mimeTypes = {"audio/mpeg","audio/mp3" , "application/octet-stream"},
     *  mimeTypesMessage = "Please upload a valid audio file, we current only support mp3.",
     *  notFoundMessage = "The file could not be found",
     *  notReadableMessage = "The file is not readable",
     *  uploadErrorMessage = "The file could not be uploaded",
     *  uploadFormSizeErrorMessage = "The file is too large",
     *  uploadIniSizeErrorMessage = "The file is too large. Allowed maximum size is {{ limit }}"
     * )
     * 
     */
    public $song;

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
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member", inversedBy="uploadSongs" )
     */
    protected $createdBy;

    /**
     * @var string
     *
     * 
     * @Assert\MinLength(limit= 2, message="Message must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Message has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="reject_message", type="string", length=100 , nullable=true)
     * @Gedmo\Versioned
     */
    protected $rejectMessage;    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member", inversedBy="uploadSongs" )
     */
    protected $rejectedBy;
    
     /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="rejected_at", type="datetime", nullable=true)
     */
    protected $rejectedAt;   

    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
        return 'uploads/songs/tmp';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->song) {
            $this->path = $this->song->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->song) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does

        $this->song->move($this->getUploadRootDir(), $this->id . '.mp3');
        unset($this->song);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($this->song = $this->getAbsolutePath()) {
            unlink($this->song);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->id . '.' . $this->path;
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
     * Set title
     *
     * @param string $title
     * @return SongTemp
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return SongTemp
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
     * @return SongTemp
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
     * @return SongTemp
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
     * Set agency
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $agency
     * @return SongTemp
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
     * Set artist
     *
     * @param \Vanessa\CoreBundle\Entity\Artist $artist
     * @return SongTemp
     */
    public function setArtist(\Vanessa\CoreBundle\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \Vanessa\CoreBundle\Entity\Artist 
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Add genres
     *
     * @param \Vanessa\CoreBundle\Entity\Genre $genres
     * @return SongTemp
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
     * @return SongTemp
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
     * @return SongTemp
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
     * Set slug
     *
     * @param string $slug
     * @return SongTemp
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
     * Set featuredArtist
     *
     * @param string $featuredArtist
     * @return SongTemp
     */
    public function setFeaturedArtist($featuredArtist)
    {
        $this->featuredArtist = $featuredArtist;

        return $this;
    }

    /**
     * Get featuredArtist
     *
     * @return string 
     */
    public function getFeaturedArtist()
    {
        return $this->featuredArtist;
    }

    /**
     * Set rejectMessage
     *
     * @param string $rejectMessage
     * @return SongTemp
     */
    public function setRejectMessage($rejectMessage)
    {
        $this->rejectMessage = $rejectMessage;

        return $this;
    }

    /**
     * Get rejectMessage
     *
     * @return string 
     */
    public function getRejectMessage()
    {
        return $this->rejectMessage;
    }

    /**
     * Set rejectedAt
     *
     * @param \DateTime $rejectedAt
     * @return SongTemp
     */
    public function setRejectedAt($rejectedAt)
    {
        $this->rejectedAt = $rejectedAt;

        return $this;
    }

    /**
     * Get rejectedAt
     *
     * @return \DateTime 
     */
    public function getRejectedAt()
    {
        return $this->rejectedAt;
    }

    /**
     * Set rejectedBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $rejectedBy
     * @return SongTemp
     */
    public function setRejectedBy(\Vanessa\CoreBundle\Entity\Member $rejectedBy = null)
    {
        $this->rejectedBy = $rejectedBy;

        return $this;
    }

    /**
     * Get rejectedBy
     *
     * @return \Vanessa\CoreBundle\Entity\Member 
     */
    public function getRejectedBy()
    {
        return $this->rejectedBy;
    }

    /**
     * Set fullVersion
     *
     * @param string $fullVersion
     * @return SongTemp
     */
    public function setFullVersion($fullVersion)
    {
        $this->fullVersion = $fullVersion;

        return $this;
    }

    /**
     * Get fullVersion
     *
     * @return string 
     */
    public function getFullVersion()
    {
        return $this->fullVersion;
    }

    /**
     * Set previewVersion
     *
     * @param string $previewVersion
     * @return SongTemp
     */
    public function setPreviewVersion($previewVersion)
    {
        $this->previewVersion = $previewVersion;

        return $this;
    }

    /**
     * Get previewVersion
     *
     * @return string 
     */
    public function getPreviewVersion()
    {
        return $this->previewVersion;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return SongTemp
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isPreviewVersionDone
     *
     * @param boolean $isPreviewVersionDone
     * @return SongTemp
     */
    public function setIsPreviewVersionDone($isPreviewVersionDone)
    {
        $this->isPreviewVersionDone = $isPreviewVersionDone;

        return $this;
    }

    /**
     * Get isPreviewVersionDone
     *
     * @return boolean 
     */
    public function getIsPreviewVersionDone()
    {
        return $this->isPreviewVersionDone;
    }

    /**
     * Set isFullVersionDone
     *
     * @param boolean $isFullVersionDone
     * @return SongTemp
     */
    public function setIsFullVersionDone($isFullVersionDone)
    {
        $this->isFullVersionDone = $isFullVersionDone;

        return $this;
    }

    /**
     * Get isFullVersionDone
     *
     * @return boolean 
     */
    public function getIsFullVersionDone()
    {
        return $this->isFullVersionDone;
    }

    /**
     * Set isrc
     *
     * @param string $isrc
     * @return SongTemp
     */
    public function setIsrc($isrc)
    {
        $this->isrc = $isrc;

        return $this;
    }

    /**
     * Get isrc
     *
     * @return string 
     */
    public function getIsrc()
    {
        return $this->isrc;
    }
}
