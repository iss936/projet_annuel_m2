<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\ManyToOne(targetEntity="Ath\MainBundle\Entity\UserDiscussion", inversedBy="messages")
     * @ORM\JoinColumn(name="user_discussion_id", referencedColumnName="id")
     */
    private $userDiscussion;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_emetteur_id", referencedColumnName="id")
     */
    private $userEmetteur;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_destinataire_id", referencedColumnName="id")
     */
    private $userDestinataire;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;

    /**
     * @var bool
     *
     * @ORM\Column(name="lu", type="boolean")
     */
    private $lu;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return Message
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set lu
     *
     * @param boolean $lu
     * @return Message
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu
     *
     * @return boolean 
     */
    public function getLu()
    {
        return $this->lu;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
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
     * @return Message
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
     * Set userDiscussion
     *
     * @param \Ath\MainBundle\Entity\UserDiscussion $userDiscussion
     * @return Message
     */
    public function setUserDiscussion(\Ath\MainBundle\Entity\UserDiscussion $userDiscussion = null)
    {
        $this->userDiscussion = $userDiscussion;

        return $this;
    }

    /**
     * Get userDiscussion
     *
     * @return \Ath\MainBundle\Entity\UserDiscussion 
     */
    public function getUserDiscussion()
    {
        return $this->userDiscussion;
    }

    /**
     * Set userEmetteur
     *
     * @param \Ath\UserBundle\Entity\User $userEmetteur
     * @return Message
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
     * @return Message
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
}
