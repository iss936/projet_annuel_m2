<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User", inversedBy="produits")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

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
     * @ORM\ManyToOne(targetEntity="Ath\MainBundle\Entity\CategorieProduit", inversedBy="produits")
     * @ORM\JoinColumn(name="categorie_produit_id", referencedColumnName="id")
     */
    private $categorieProduit;

    /**
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\FileProduit", mappedBy="produit", cascade={"persist", "remove"})
     */
    private $fileProduits;

    /**
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fileProduits = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Produit
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
     * @return Produit
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
     * Set createdBy
     *
     * @param string $createdBy
     * @return Produit
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Produit
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
     * @return Produit
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
     * Set categorieProduit
     *
     * @param string $categorieProduit
     * @return Produit
     */
    public function setCategorieProduit($categorieProduit)
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }

    /**
     * Get categorieProduit
     *
     * @return string 
     */
    public function getCategorieProduit()
    {
        return $this->categorieProduit;
    }

    /**
     * Get fileProduits
     *
     * @return Array collection of fileProduits
     */
    public function getFileProduits()
    {
        return $this->fileProduits;
    }

    /**
     * Add fileProduit
     *
     * @param \Ath\MainBundle\Entity\FileProduit $fileProduit
     *
     * @return Produit
     */
    public function addFileProduit(\Ath\MainBundle\Entity\FileProduit $fileProduit)
    {
        if (!$this->fileProduits->contains($fileProduit))
            $this->fileProduits[] = $fileProduit;

        return $this;
    }

    /**
     * Remove fileProduit
     *
     * @param \Ath\MainBundle\Entity\FileProduit $fileProduit
     */
    public function removefileProduit(\Ath\MainBundle\Entity\FileProduit $fileProduit)
    {
        $this->fileProduits->removeElement($fileProduit);
    }

    /**
     * Set prix
     *
     * @param float $prix
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Produit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
}
