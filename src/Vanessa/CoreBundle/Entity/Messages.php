<?php

namespace Vanessa\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vanessa\CoreBundle\Entity\Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="Vanessa\CoreBundle\Repository\MessagesRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Entity
 * @version 0.0.1
 */
class Messages
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
     * @var Vanessa\CoreBundle\Entity\MessageType
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\MessageType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="message_type_id", referencedColumnName="id")
     * })
     * 
     */
    protected $messageType;    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Vanessa\CoreBundle\Entity\Member")
     */
    protected $recipient;    
    
    /**
     * @var string
     *
     * @Assert\NotBlank(message = "Content cannot be blank!")
     * @Assert\MinLength(limit= 2, message="Content must have at least {{ limit }} characters.")
     * @Assert\MaxLength(limit= 300, message="Content has a limit of {{ limit }} characters.")
     *
     * @ORM\Column(name="content", type="text")
     * 
     */
    protected $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_read", type="boolean")
     * 
     */
    protected $isRead = false;
    
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
     * @var datetime $expiredAt
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=false)
     */
    protected $expiredAt;    

    public function __toString()
    {
        return $this->getContent();
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
     * Set content
     *
     * @param string $content
     * @return Messages
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     * @return Messages
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean 
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Messages
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
     * @return Messages
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
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     * @return Messages
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime 
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set recipient
     *
     * @param \Vanessa\CoreBundle\Entity\Member $recipient
     * @return Messages
     */
    public function setRecipient(\Vanessa\CoreBundle\Entity\Member $recipient = null)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \Vanessa\CoreBundle\Entity\Member 
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set messageType
     *
     * @param \Vanessa\CoreBundle\Entity\MessageType $messageType
     * @return Messages
     */
    public function setMessageType(\Vanessa\CoreBundle\Entity\MessageType $messageType = null)
    {
        $this->messageType = $messageType;

        return $this;
    }

    /**
     * Get messageType
     *
     * @return \Vanessa\CoreBundle\Entity\MessageType 
     */
    public function getMessageType()
    {
        return $this->messageType;
    }
}
