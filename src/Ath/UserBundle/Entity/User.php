<?php

namespace Ath\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              type =  "string",
 *              name     = "email",
 *              nullable = false,
 *              unique   = true
 *          )
 *      ),
 * })
 * @ORM\Entity(repositoryClass="Ath\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="datetime")
     */
    private $dateDeNaissance;

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
     * @var string
     *
     * @ORM\Column(name="photo_id", type="string", length=255, nullable=true)
     */
    private $photoId;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_extension", type="string", length=255, nullable=true)
     */
    private $photoExtension;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_original_name", type="string", length=255, nullable=true)
     */
    private $photoOriginalName;

    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=255, nullable=true)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=5, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="genre", type="boolean")
     */
    private $genre = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="cgu", type="boolean")
     */
    private $cgu = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserContact", mappedBy="userEmmeteur")
     */
    private $userContactEmmeteurs;

    /**
     * @var ArrayCollection User $userContactDestinataires
     * 
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserContact", mappedBy="userDestinataire")
     */
    private $userContactDestinataires;

    public function __construct()
    {
        parent::__construct();
        $this->userContactEmmeteurs = new ArrayCollection();
        $this->userContactDestinataires = new ArrayCollection();
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
    
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     * @return User
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime 
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * Set photoId
     *
     * @param string $photoId
     * @return User
     */
    public function setPhotoId($photoId)
    {
        $this->photoId = $photoId;

        return $this;
    }

    /**
     * Get photoId
     *
     * @return string 
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * Set photoExtension
     *
     * @param string $photoExtension
     * @return User
     */
    public function setPhotoExtension($photoExtension)
    {
        $this->photoExtension = $photoExtension;

        return $this;
    }

    /**
     * Get photoExtension
     *
     * @return string 
     */
    public function getPhotoExtension()
    {
        return $this->photoExtension;
    }

    /**
     * Set photoOriginalName
     *
     * @param string $photoOriginalName
     * @return User
     */
    public function setPhotoOriginalName($photoOriginalName)
    {
        $this->photoOriginalName = $photoOriginalName;

        return $this;
    }

    /**
     * Get photoOriginalName
     *
     * @return string 
     */
    public function getPhotoOriginalName()
    {
        return $this->photoOriginalName;
    }

    /**
     * Set rue
     *
     * @param string $rue
     * @return User
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string 
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set genre
     *
     * @param boolean $genre
     * @return User
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return boolean 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set cgu
     *
     * @param boolean $cgu
     * @return User
     */
    public function setCgu($cgu)
    {
        $this->cgu = $cgu;

        return $this;
    }

    /**
     * Get cgu
     *
     * @return boolean 
     */
    public function getCgu()
    {
        return $this->cgu;
    }
    
    /**
     * Add userContactEmmeteur
     *
     * @param \Ath\Mainundle\Entity\UserContact $userContactEmmeteur
     * @return User
     */
    public function addUserContactEmmeteur(\Ath\MainBundle\Entity\UserContact $userContactEmmeteur)
    {
        if (!$this->userContactEmmeteurs->contains($userContactEmmeteur)) {
                $this->userContactEmmeteurs->add($userContactEmmeteur);
        }

        return $this;
    }

    /**
    * Remove userContactEmmeteur
    *
    * @param \Ath\Mainundle\Entity\UserContact $userContactEmmeteur
    */
    public function removeUserContactEmmeteur(\Ath\Mainundle\Entity\UserContact $userContactEmmeteur)
    {
      $this->userContactEmmeteurs->removeElement($userContactEmmeteur);
    }

    /**
     * Get userContactEmmeteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getuserContactEmmeteurs()
    {
      return $this->userContactEmmeteurs;
    }

    /**
     * Add userContactDestinataire
     *
     * @param \Ath\Mainundle\Entity\UserContact $userContactDestinataire
     * @return User
     */
    public function addUserContactDestinataire(\Ath\MainBundle\Entity\UserContact $userContactDestinataire)
    {
        if (!$this->userContactDestinataires->contains($userContactDestinataire))
            $this->userContactDestinataires->add($userContactDestinataire);
        
        return $this;
    }

    /**
     * Remove userContactDestinataire
     *
     * @param \Ath\Mainundle\Entity\UserContact $userContactDestinataire
     */
    public function removeUserContactDestinataire(\Ath\Mainundle\Entity\UserContact $userContactDestinataire)
    {
      $this->userContactDestinataires->removeElement($userContactDestinataire);
    }

    /**
     * Get userContactDestinataires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getuserContactDestinataires()
    {
      return $this->userContactDestinataires;
    }

}
