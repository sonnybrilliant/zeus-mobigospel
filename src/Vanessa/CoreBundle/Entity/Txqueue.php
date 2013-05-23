<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Txqueue
 *
 * @ORM\Table(name="txqueue")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\TxqueueRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Txqueue
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
     * @var Vanessa\CoreBundle\Entity\Rxqueue
     * 
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Rxqueue")
     * @ORM\JoinColumn(name="rxqueue_id", referencedColumnName="id")
     * 
     */
    protected $rxqueue;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn", type="string", length=20)
     * 
     */
    protected $msisdn;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     * 
     */
    protected $body;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=true)
     * 
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="outgoing_payload", type="text" , nullable=true)
     * 
     */
    protected $outgoingPayload;

    /**
     * @var string
     *
     * @ORM\Column(name="incoming_payload", type="text" , nullable=true)
     * 
     */
    protected $incomingPayload;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_valid", type="boolean")
     * 
     */
    protected $isValid = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sent", type="boolean")
     * 
     */
    protected $isSent = true;

    /**
     * @var string
     *
     * @ORM\Column(name="seqno", type="string", length=20, nullable=true)
     * 
     */
    protected $seqno;

    /**
     * @var string
     *
     * @ORM\Column(name="network", type="integer", length=5 , nullable=true)
     * 
     */
    protected $network;    
    
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set msisdn
     *
     * @param string $msisdn
     * @return Txqueue
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
     * Set body
     *
     * @param string $body
     * @return Txqueue
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Txqueue
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set outgoingPayload
     *
     * @param string $outgoingPayload
     * @return Txqueue
     */
    public function setOutgoingPayload($outgoingPayload)
    {
        $this->outgoingPayload = $outgoingPayload;
    
        return $this;
    }

    /**
     * Get outgoingPayload
     *
     * @return string 
     */
    public function getOutgoingPayload()
    {
        return $this->outgoingPayload;
    }

    /**
     * Set incomingPayload
     *
     * @param string $incomingPayload
     * @return Txqueue
     */
    public function setIncomingPayload($incomingPayload)
    {
        $this->incomingPayload = $incomingPayload;
    
        return $this;
    }

    /**
     * Get incomingPayload
     *
     * @return string 
     */
    public function getIncomingPayload()
    {
        return $this->incomingPayload;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     * @return Txqueue
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    
        return $this;
    }

    /**
     * Get isValid
     *
     * @return boolean 
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set isSent
     *
     * @param boolean $isSent
     * @return Txqueue
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;
    
        return $this;
    }

    /**
     * Get isSent
     *
     * @return boolean 
     */
    public function getIsSent()
    {
        return $this->isSent;
    }

    /**
     * Set seqno
     *
     * @param string $seqno
     * @return Txqueue
     */
    public function setSeqno($seqno)
    {
        $this->seqno = $seqno;
    
        return $this;
    }

    /**
     * Get seqno
     *
     * @return string 
     */
    public function getSeqno()
    {
        return $this->seqno;
    }

    /**
     * Set network
     *
     * @param integer $network
     * @return Txqueue
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    
        return $this;
    }

    /**
     * Get network
     *
     * @return integer 
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Txqueue
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
     * @return Txqueue
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
     * Set rxqueue
     *
     * @param \Vanessa\CoreBundle\Entity\Rxqueue $rxqueue
     * @return Txqueue
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
}
