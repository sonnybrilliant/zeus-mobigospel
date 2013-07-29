<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Song
 *
 * @ORM\Table(name="song",
 *      indexes={@ORM\Index(name="search_context", columns={"title","featured_artist","stage_name"})}
 * )
 * 
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\SongRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @Gedmo\Loggable
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Song
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
     * @var Vanessa\CoreBundle\Entity\SongTemp
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\SongTemp")
     * @ORM\JoinColumn(name="song_temp_id", referencedColumnName="id")
     * 
     */
    protected $songTemp;

    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Song title cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Song title must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 100, message="Song title has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="title", type="string", length=100)
     * @Gedmo\Versioned
     * 
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
     * @ORM\Column(name="stage_name", type="string", length=255 , nullable=true)
     * 
     */
    protected $stageName;

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
     * @Gedmo\Versioned
     */
    protected $agency;

    /**
     * @var Vanessa\CoreBundle\Entity\Artist
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     * 
     */
    protected $artist;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Vanessa\CoreBundle\Entity\Genre")
     * @ORM\JoinTable(name="song_genre_map",
     *     joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
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
     * @ORM\Column(name="is_deleted", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isDeleted = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * @Gedmo\Versioned
     */
    protected $isActive = true;

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

    /**
     * Set title
     *
     * @param string $title
     * @return Song
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
     * Set slug
     *
     * @param string $slug
     * @return Song
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
     * @return Song
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Song
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Song
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
     * @return Song
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
     * Set songTemp
     *
     * @param \Vanessa\CoreBundle\Entity\SongTemp $songTemp
     * @return Song
     */
    public function setSongTemp(\Vanessa\CoreBundle\Entity\SongTemp $songTemp = null)
    {
        $this->songTemp = $songTemp;

        return $this;
    }

    /**
     * Get songTemp
     *
     * @return \Vanessa\CoreBundle\Entity\SongTemp 
     */
    public function getSongTemp()
    {
        return $this->songTemp;
    }

    /**
     * Set agency
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $agency
     * @return Song
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
     * @return Song
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
     * @return Song
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
     * Set createdBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $createdBy
     * @return Song
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
     * Set stageName
     *
     * @param string $stageName
     * @return Song
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
     * Set featuredArtist
     *
     * @param string $featuredArtist
     * @return Song
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
     * Set status
     *
     * @param \Vanessa\CoreBundle\Entity\Status $status
     * @return Song
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
}
