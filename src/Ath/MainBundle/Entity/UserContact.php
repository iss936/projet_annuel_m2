<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContact
 *
 * @ORM\Table(name="user_contact")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\UserContactRepository")
 */
class UserContact
{
    
    /**
     * @var \Ath\UserBundle\Entity\User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userContactEmmeteurs")
     * @ORM\JoinColumn(name="user_emmeteur_id", referencedColumnName="id")
     */
    private $userEmmeteur;

    /**
     * @var \Ath\UserBundle\Entity\User
     * @ORM\Id
     * 
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userContactDestinataires")
     * @ORM\JoinColumn(name="user_destinataire_id", referencedColumnName="id")
     */
    private $userDestinataire;

    /**
     * @var bool
     *
     * @ORM\Column(name="accepte", type="boolean", nullable=true)
     */
    private $accepte;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="datetimetz")
     */
    private $dateDemande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_validation", type="datetimetz", nullable=true)
     */
    private $dateValidation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_refus", type="datetimetz", nullable=true)
     */
    private $dateRefus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetimetz")
     */
    private $updatedAt;



    /**
     * Set accepte
     *
     * @param boolean $accepte
     * @return UserContact
     */
    public function setAccepte($accepte)
    {
        $this->accepte = $accepte;

        return $this;
    }

    /**
     * Get accepte
     *
     * @return boolean 
     */
    public function getAccepte()
    {
        return $this->accepte;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return UserContact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     * @return UserContact
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime 
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set dateValidation
     *
     * @param \DateTime $dateValidation
     * @return UserContact
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return \DateTime 
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set dateRefus
     *
     * @param \DateTime $dateRefus
     * @return UserContact
     */
    public function setDateRefus($dateRefus)
    {
        $this->dateRefus = $dateRefus;

        return $this;
    }

    /**
     * Get dateRefus
     *
     * @return \DateTime 
     */
    public function getDateRefus()
    {
        return $this->dateRefus;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserContact
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
     * @return UserContact
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
     * Set userEmmeteur
     *
     * @param \Ayh\UserBundle\Entity\User $userEmmeteur
     * @return UserContact
     */
    public function setUserEmmeteur(\Ayh\UserBundle\Entity\User $userEmmeteur = null)
    {
        $this->userEmmeteur = $userEmmeteur;

        return $this;
    }

    /**
     * Get userEmmeteur
     *
     * @return \Ayh\UserBundle\Entity\User 
     */
    public function getUserEmmeteur()
    {
        return $this->userEmmeteur;
    }

    /**
     * Set userDestinataire
     *
     * @param \Ayh\UserBundle\Entity\User $userDestinataire
     * @return UserContact
     */
    public function setUserDestinataire(\Ayh\UserBundle\Entity\User $userDestinataire = null)
    {
        $this->userDestinataire = $userDestinataire;

        return $this;
    }

    /**
     * Get userDestinataire
     *
     * @return \Ayh\UserBundle\Entity\User 
     */
    public function getUserDestinataire()
    {
        return $this->userDestinataire;
    }
}
