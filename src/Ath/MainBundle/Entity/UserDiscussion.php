<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UserDiscussion
 *
 * @ORM\Table(name="user_discussion")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\UserDiscussionRepository")
 */
class UserDiscussion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userDiscussionEmetteurs")
     * @ORM\JoinColumn(name="user_emetteur_id", referencedColumnName="id")
     */
    private $userEmetteur;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userDiscussionDestinataires")
     * @ORM\JoinColumn(name="user_destinataire_id", referencedColumnName="id")
     */
    private $userDestinataire;

    /**
     * Creation date
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Modification date
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\Message", mappedBy="userDiscussion")
     */
    private $messages;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserDiscussion
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
     * @return UserDiscussion
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
     * Set userEmetteur
     *
     * @param \Ath\UserBundle\Entity\User $userEmetteur
     * @return UserDiscussion
     */
    public function setUserEmetteur(\Ath\UserBundle\Entity\User $userEmetteur = null)
    {
        $this->userEmetteur = $userEmetteur;

        return $this;
    }

    /**
     * Get userEmetteur
     *
     * @return \Ath\UserBundle\Entity\User 
     */
    public function getUserEmetteur()
    {
        return $this->userEmetteur;
    }

    /**
     * Set userDestinataire
     *
     * @param \Ath\UserBundle\Entity\User $userDestinataire
     * @return UserDiscussion
     */
    public function setUserDestinataire(\Ath\UserBundle\Entity\User $userDestinataire = null)
    {
        $this->userDestinataire = $userDestinataire;

        return $this;
    }

    /**
     * Get userDestinataire
     *
     * @return \Ath\UserBundle\Entity\User 
     */
    public function getUserDestinataire()
    {
        return $this->userDestinataire;
    }
   

    /**
     * Add messages
     *
     * @param \Ath\MainBundle\Entity\Message $messages
     * @return UserDiscussion
     */
    public function addMessage(\Ath\MainBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \Ath\MainBundle\Entity\Message $messages
     */
    public function removeMessage(\Ath\MainBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
