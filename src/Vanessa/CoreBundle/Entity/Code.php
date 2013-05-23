<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Code
 *
 * @ORM\Table(name="code")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\CodeRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @DoctrineAssert\UniqueEntity(fields={"code"}, message="The code you have chosen is already in use, please try another one.")
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Code
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
     * @var Vanessa\CoreBundle\Entity\Song
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Song")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     * 
     */
    protected $song;

    /**
     * @var Vanessa\CoreBundle\Entity\Agency
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Agency")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     * 
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
     * @var string
     *
     * @Assert\NotBlank(message = "Song code cannot be blank!")
     * @Assert\MinLength(limit= 5, message="Song code must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 10, message="Song code has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="code", type="string", length=20 , unique=true)
     * 
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="search_artist", type="string", length=50)
     * 
     */
    protected $searchArtist;

    /**
     * @var string
     *
     * @ORM\Column(name="search_agency", type="string", length=50)
     * 
     */
    protected $searchAgency;

    /**
     * @var string
     *
     * @ORM\Column(name="search_song", type="string", length=50)
     * 
     */
    protected $searchSong;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     * 
     */
    protected $isDeleted = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     * 
     */
    protected $isActive = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="can_edit", type="boolean")
     * 
     */
    protected $canEdit = true;

    /**
     * @var integer
     *
     * @ORM\Column(name="download_counter", type="integer" , nullable=true)
     * 
     */
    protected $downloadCounter = 0;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member", inversedBy="uploadSongs" )
     */
    protected $createdBy;

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

    public function __construct()
    {
        $this->isActive = true;
        $this->isDeleted = false;
    }

    public function __toString()
    {
        return $this->getCode();
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
     * Set code
     *
     * @param string $code
     * @return Code
     */
    public function setCode($code)
    {
        $this->code = strtoupper($code);

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set searchArtist
     *
     * @param string $searchArtist
     * @return Code
     */
    public function setSearchArtist($searchArtist)
    {
        $this->searchArtist = $searchArtist;

        return $this;
    }

    /**
     * Get searchArtist
     *
     * @return string 
     */
    public function getSearchArtist()
    {
        return $this->searchArtist;
    }

    /**
     * Set searchAgency
     *
     * @param string $searchAgency
     * @return Code
     */
    public function setSearchAgency($searchAgency)
    {
        $this->searchAgency = $searchAgency;

        return $this;
    }

    /**
     * Get searchAgency
     *
     * @return string 
     */
    public function getSearchAgency()
    {
        return $this->searchAgency;
    }

    /**
     * Set searchSong
     *
     * @param string $searchSong
     * @return Code
     */
    public function setSearchSong($searchSong)
    {
        $this->searchSong = $searchSong;

        return $this;
    }

    /**
     * Get searchSong
     *
     * @return string 
     */
    public function getSearchSong()
    {
        return $this->searchSong;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Code
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
     * @return Code
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
     * @return Code
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
     * @return Code
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
     * Set song
     *
     * @param \Vanessa\CoreBundle\Entity\Song $song
     * @return Code
     */
    public function setSong(\Vanessa\CoreBundle\Entity\Song $song = null)
    {
        $this->song = $song;

        return $this;
    }

    /**
     * Get song
     *
     * @return \Vanessa\CoreBundle\Entity\Song 
     */
    public function getSong()
    {
        return $this->song;
    }

    /**
     * Set agency
     *
     * @param \Vanessa\CoreBundle\Entity\Agency $agency
     * @return Code
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
     * @return Code
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
     * Set createdBy
     *
     * @param \Vanessa\CoreBundle\Entity\Member $createdBy
     * @return Code
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
     * Set canEdit
     *
     * @param boolean $canEdit
     * @return Code
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;

        return $this;
    }

    /**
     * Get canEdit
     *
     * @return boolean 
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

    /**
     * Set downloadCounter
     *
     * @param integer $downloadCounter
     * @return Code
     */
    public function setDownloadCounter($downloadCounter)
    {
        $this->downloadCounter = $downloadCounter;
    
        return $this;
    }

    /**
     * Get downloadCounter
     *
     * @return integer 
     */
    public function getDownloadCounter()
    {
        return $this->downloadCounter;
    }
}
