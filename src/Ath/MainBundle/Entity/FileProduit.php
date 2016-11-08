<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * FileProduit
 *
 * @ORM\Table(name="file_produit")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\FileProduitRepository")
 * @ORM\HasLifecycleCallbacks
 */
class FileProduit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_fichier", type="string", length=255, nullable = true)
     */
    private $nomFichier;

    /**
     * @var string
     *
     * @ORM\Column(name="type_fichier", type="string", length=255, nullable = true)
     */
    private $typeFichier;

    /**
     * @var string
     *
     * @ORM\Column(name="original_fichier", type="string", length=255, nullable = true)
     */
    private $originalFichier;

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
     * @ORM\ManyToOne(targetEntity="Ath\MainBundle\Entity\Produit", inversedBy="fileProduits")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     */
    private $produit;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

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
     * Set nomFichier
     *
     * @param string $nomFichier
     *
     * @return FileProduit
     */
    public function setNomFichier($nomFichier)
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    /**
     * Get nomFichier
     *
     * @return string
     */
    public function getNomFichier()
    {
        return $this->nomFichier;
    }

    /**
     * Set typeFichier
     *
     * @param string $typeFichier
     *
     * @return FileProduit
     */
    public function setTypeFichier($typeFichier)
    {
        $this->typeFichier = $typeFichier;

        return $this;
    }

    /**
     * Get typeFichier
     *
     * @return string
     */
    public function getTypeFichier()
    {
        return $this->typeFichier;
    }

    /**
     * Set originalFichier
     *
     * @param string $originalFichier
     *
     * @return FileProduit
     */
    public function setOriginalFichier($originalFichier)
    {
        $this->originalFichier = $originalFichier;

        return $this;
    }

    /**
     * Get originalFichier
     *
     * @return string
     */
    public function getOriginalFichier()
    {
        return $this->originalFichier;
    }

    /**
     * Set createdAt
     *
     * @param dateTime $createdAt
     *
     * @return FileProduit
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return dateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param dateTime $updatedAt
     *
     * @return FileProduit
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return dateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set produit
     *
     * @param Ath\MainBundle\Entity\Produit $produit
     *
     * @return FileProduit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return Ath\MainBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }


    /*** GESTION UPLOADS ***/

    public function getAbsolutePath()
    {
        return null === $this->nomFichier
             ? null
             : $this->getUploadRootDir().'/'.$this->nomFichier;
    }

    public function getWebPath()
    {
        return null === $this->nomFichier
             ? null
             : $this->getUploadDir().'/'.$this->nomFichier;
    }

    protected function getUploadRootDir() 
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/posts/files';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->nomFichier = $filename.'.'.$this->getFile()->guessExtension();
            $this->typeFichier = $this->file->guessExtension();
            $this->originalFichier = $this->file->getClientOriginalName();
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
        $this->file->move($this->getUploadRootDir(), $this->nomFichier);

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
        if ($this->getNomFichier()) {
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
            if (isset($this->nomFichier)) {
                // store the old name to delete after the update
                $this->temp = $this->nomFichier;
                $this->nomFichier = null;
            }
             else {
                $this->nomFichier = 'initial';
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
  /**** FIN GESTION UPLOADS ****/

    public function __toString()
    {
        return $this->nomFichier;
    }
}

