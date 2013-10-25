<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Download
 *
 * @ORM\Table(name="download")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\DownloadRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Download
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
     * @var Vanessa\CoreBundle\Entity\Rxqueue
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Rxqueue")
     * @ORM\JoinColumn(name="rxqueue_id", referencedColumnName="id")
     * 
     */
    protected $rxqueue;

    /**
     * @var Vanessa\CoreBundle\Entity\Code
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Code")
     * @ORM\JoinColumn(name="code_id", referencedColumnName="id")
     * 
     */
    protected $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_downloaded", type="boolean")
     * 
     */
    protected $isDownloaded = false;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="download_counter", type="integer" , nullable=true)
     * 
     */
    protected $downloadCounter = 0;    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_checked_out", type="boolean")
     * 
     */
    protected $isCheckedOut = false;    

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=100)
     * 
     */
    protected $token;

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
     * @ORM\Column(name="search_code", type="string", length=50)
     * 
     */
    protected $searchCode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="search_song", type="string", length=100)
     * 
     */
    protected $searchSong;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn", type="string", length=15)
     * 
     */
    protected $msisdn;     

    /**
     * @var datetime 
     *
     * @ORM\Column(name="checkout_at", type="datetime")
     */
    protected $checkoutAt;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="downloaded_at", type="datetime", nullable=true)
     */
    protected $downloadedAt;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->isDownloaded = false;
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
     * Set isDownloaded
     *
     * @param boolean $isDownloaded
     * @return Download
     */
    public function setIsDownloaded($isDownloaded)
    {
        $this->isDownloaded = $isDownloaded;
    
        return $this;
    }

    /**
     * Get isDownloaded
     *
     * @return boolean 
     */
    public function getIsDownloaded()
    {
        return $this->isDownloaded;
    }

    /**
     * Set isCheckedOut
     *
     * @param boolean $isCheckedOut
     * @return Download
     */
    public function setIsCheckedOut($isCheckedOut)
    {
        $this->isCheckedOut = $isCheckedOut;
    
        return $this;
    }

    /**
     * Get isCheckedOut
     *
     * @return boolean 
     */
    public function getIsCheckedOut()
    {
        return $this->isCheckedOut;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Download
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set searchAgency
     *
     * @param string $searchAgency
     * @return Download
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
     * Set searchCode
     *
     * @param string $searchCode
     * @return Download
     */
    public function setSearchCode($searchCode)
    {
        $this->searchCode = $searchCode;
    
        return $this;
    }

    /**
     * Get searchCode
     *
     * @return string 
     */
    public function getSearchCode()
    {
        return $this->searchCode;
    }

    /**
     * Set searchSong
     *
     * @param string $searchSong
     * @return Download
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
     * Set msisdn
     *
     * @param string $msisdn
     * @return Download
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    
        return $this;
    }

    /**
     * Get msisdn
     *
     * @return string 
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * Set checkoutAt
     *
     * @param \DateTime $checkoutAt
     * @return Download
     */
    public function setCheckoutAt($checkoutAt)
    {
        $this->checkoutAt = $checkoutAt;
    
        return $this;
    }

    /**
     * Get checkoutAt
     *
     * @return \DateTime 
     */
    public function getCheckoutAt()
    {
        return $this->checkoutAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Download
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
     * @return Download
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
     * @return Download
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
     * @return Download
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
     * Set rxqueue
     *
     * @param \Vanessa\CoreBundle\Entity\Rxqueue $rxqueue
     * @return Download
     */
    public function setRxqueue(\Vanessa\CoreBundle\Entity\Rxqueue $rxqueue = null)
    {
        $this->rxqueue = $rxqueue;
    
        return $this;
    }

    /**
     * Get rxqueue
     *
     * @return \Vanessa\CoreBundle\Entity\Rxqueue 
     */
    public function getRxqueue()
    {
        return $this->rxqueue;
    }

    /**
     * Set code
     *
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return Download
     */
    public function setCode(\Vanessa\CoreBundle\Entity\Code $code = null)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return \Vanessa\CoreBundle\Entity\Code 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set downloadCounter
     *
     * @param integer $downloadCounter
     * @return Download
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

    /**
     * Set downloadedAt
     *
     * @param \DateTime $downloadedAt
     * @return Download
     */
    public function setDownloadedAt($downloadedAt)
    {
        $this->downloadedAt = $downloadedAt;
    
        return $this;
    }

    /**
     * Get downloadedAt
     *
     * @return \DateTime 
     */
    public function getDownloadedAt()
    {
        return $this->downloadedAt;
    }
}
