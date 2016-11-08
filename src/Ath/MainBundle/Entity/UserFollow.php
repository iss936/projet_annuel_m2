<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UserFollow
 *
 * @ORM\Table(name="user_follow")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\UserFollowRepository")
 */
class UserFollow
{
    /**
     * @var \Ath\UserBundle\Entity\User
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userEmetteursFollow")
     * @ORM\JoinColumn(name="user_emetteur", referencedColumnName="id")
     */
    private $userEmetteur;

    /**
     * @var \Ath\UserBundle\Entity\User
     * 
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="userDestinatairesFollow")
     * @ORM\JoinColumn(name="user_destinataire", referencedColumnName="id")
     */
    private $userDestinataire;

    /**
     * Creation date
     * @var datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Modification date
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="datetime")
     */
    private $dateDemande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reponse", type="datetime")
     */
    private $dateReponse;

    /**
     * @var bool
     *
     * @ORM\Column(name="accepte", type="boolean")
     */
    private $accepte;
    
    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserFollow
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
     * @return UserFollow
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
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     * @return UserFollow
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
     * Set dateReponse
     *
     * @param \DateTime $dateReponse
     * @return UserFollow
     */
    public function setDateReponse($dateReponse)
    {
        $this->dateReponse = $dateReponse;

        return $this;
    }

    /**
     * Get dateReponse
     *
     * @return \DateTime 
     */
    public function getDateReponse()
    {
        return $this->dateReponse;
    }

    /**
     * Set accepte
     *
     * @param boolean $accepte
     * @return UserFollow
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
     * Set userEmetteur
     *
     * @param \Ath\UserBundle\Entity\User $userEmetteur
     * @return UserFollow
     */
    public function setUserEmetteur(\Ath\UserBundle\Entity\User $userEmetteur)
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
     * @return UserFollow
     */
    public function setUserDestinataire(\Ath\UserBundle\Entity\User $userDestinataire)
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
