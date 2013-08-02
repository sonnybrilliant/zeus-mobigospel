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
 * @ORM\Table(name="rxqueue",
 *  indexes={@ORM\Index(name="search_context", columns={"msisdn","seqno"})} 
 * )
 * 
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
     * @ORM\Column(name="to_address", type="string", length=20)
     * 
     */
    protected $toAddress;

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
     * @ORM\Column(name="network", type="integer", length=5, nullable=true)
     * 
     */
    protected $network;
    
    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     * 
     */
    protected $status;    

    /**
     * @var string
     *
     * @ORM\Column(name="seqno", type="string", length=20)
     * 
     */
    protected $seqno;

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
     * Set toAddress
     *
     * @param string $toAddress
     * @return Rxqueue
     */
    public function setToAddress($toAddress)
    {
        $this->toAddress = $toAddress;

        return $this;
    }

    /**
     * Get toAddress
     *
     * @return string 
     */
    public function getToAddress()
    {
        return $this->toAddress;
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
     * Set status
     *
     * @param \Vanessa\CoreBundle\Entity\Status $status
     * @return Rxqueue
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
