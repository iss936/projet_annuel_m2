<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Ath\MainBundle\Validator\Constraints as MainAssert;

/**
 * EventAdmin
 *
 * @ORM\Table(name="event_admin")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\EventAdminRepository")
 * @UniqueEntity("libelle")
 * @ORM\HasLifecycleCallbacks
* @MainAssert\DateCompare
 */
class EventAdmin
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime")
     */
    private $dateFin;

    /**
     * @var \datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\MainBundle\Entity\Sport", cascade={"all"})
     * @ORM\OrderBy({"name" = "ASC"})
     * @ORM\JoinTable(name="event_admin_sport")
     */
    private $themeSports;

    /**
     * @ORM\Column(name="site_web", type="string", length=255)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_id", type="string", length=255)
     */
    private $photoId;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_extension", type="string", length=255)
     */
    private $photoExtension;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_original_name", type="string", length=255)
     */
    private $photoOriginalName;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themeSports = new ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     * @return EventAdmin
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EventAdmin
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return EventAdmin
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return EventAdmin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

     /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return EventAdmin
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
     * @return EventAdmin
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
     * Set createdBy
     *
     * @param \Ath\UserBundle\Entity\User $createdBy
     * @return EventAdmin
     */
    public function setCreatedBy(\Ath\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Ath\UserBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Ath\UserBundle\Entity\User $updatedBy
     * @return EventAdmin
     */
    public function setUpdatedBy(\Ath\UserBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Ath\UserBundle\Entity\User 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Add themeSports
     *
     * @param \Ath\MainBundle\Entity\Sport $themeSport
     * @return EventAdmin
     */
    public function addThemeSport(\Ath\MainBundle\Entity\Sport $themeSport)
    {
        if (!$this->themeSports->contains($themeSport)) {
            $this->themeSports[] = $themeSports;
        }

        return $this;
    }

    /**
     * Remove themeSports
     *
     * @param \Ath\MainBundle\Entity\Sport $themeSports
     */
    public function removeThemeSport(\Ath\MainBundle\Entity\Sport $themeSports)
    {
        $this->themeSports->removeElement($themeSports);
    }

    /**
     * Get themeSports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThemeSports()
    {
        return $this->themeSports;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     * @return EventAdmin
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string 
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set photoId
     *
     * @param string $photoId
     * @return EventAdmin
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
     * @return EventAdmin
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
     * @return EventAdmin
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

     /*** GESTION UPLOADS photo ***/

    public function getAbsolutePath()
    {
        return null === $this->photoId
             ? null
             : $this->getUploadRootDir().'/'.$this->photoId;
    }

    public function getWebPath()
    {
        if ($this->photoId == null) {
            return '/images/inconnu.jpg';
        }

        return $this->getUploadDir().'/'.$this->photoId;
    }

    protected function getUploadRootDir() 
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/eventAdmin';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->photoId = $filename.'.'.$this->getFile()->guessExtension();
            $this->photoExtension = $this->file->guessExtension();
            $this->photoOriginalName = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        // la propriété « file » peut être vide comme le champ n'est pas requis
        if (null === $this->file) {
          return;
        }

        if (!file_exists($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir());
        }
        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        $this->file->move($this->getUploadRootDir(), $this->photoId);

         // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            if (is_file($this->getUploadRootDir().'/'.$this->temp)) {
                unlink($this->getUploadRootDir().'/'.$this->temp);
                // clear the temp image path
                $this->temp = null;
            }
        }

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->getphotoId()) {
            $file = $this->getAbsolutePath();
            if ($file && is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if ($this->file) {
            // check if we have an old image path
            if (isset($this->photoId)) {
                // store the old name to delete after the update
                $this->temp = $this->photoId;
                $this->photoId = null;
            }
             else {
                $this->photoId = 'initial';
            }
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function removePhoto()
    {
        $file_path = $this->getUploadRootDir().'/'.$this->getPhotoId();

        if(file_exists($file_path))
        {
            unlink($file_path);
        }
    }
  /**** FIN GESTION UPLOADS ****/

    public function __toString()
    {
        return $this->libelle;
    }
}
