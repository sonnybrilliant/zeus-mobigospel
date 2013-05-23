<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Rxqueue
 *
 * @ORM\Table(name="rxqueue")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\RxqueueRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Rxqueue
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
     * @ORM\Column(name="service", type="string", length=20)
     * 
     */
    protected $service;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="integer", length=9)
     * 
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="network", type="integer", length=5, nullable=true)
     * 
     */
    protected $network;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=20)
     * 
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="seqno", type="string", length=20)
     * 
     */
    protected $seqno;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_at", type="string", length=20)
     * 
     */
    protected $sentAt;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="text")
     * 
     */
    protected $payload;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_queued", type="boolean")
     * 
     */
    protected $isQueued = false;

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
     * @return Rxqueue
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
     * @return Rxqueue
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
     * Set service
     *
     * @param string $service
     * @return Rxqueue
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Rxqueue
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Rxqueue
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set seqno
     *
     * @param string $seqno
     * @return Rxqueue
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
     * Set sentAt
     *
     * @param string $sentAt
     * @return Rxqueue
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Get sentAt
     *
     * @return string 
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Rxqueue
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
     * @return Rxqueue
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
     * Set network
     *
     * @param integer $network
     * @return Rxqueue
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
     * Set payload
     *
     * @param string $payload
     * @return Rxqueue
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get payload
     *
     * @return string 
     */
    public function getPayload()
    {
        return $this->payload;
    }


    /**
     * Set isQueued
     *
     * @param boolean $isQueued
     * @return Rxqueue
     */
    public function setIsQueued($isQueued)
    {
        $this->isQueued = $isQueued;
    
        return $this;
    }

    /**
     * Get isQueued
     *
     * @return boolean 
     */
    public function getIsQueued()
    {
        return $this->isQueued;
    }
}
