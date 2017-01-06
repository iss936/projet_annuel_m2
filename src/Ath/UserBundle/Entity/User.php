<?php

namespace Ath\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Ath\UserBundle\Validator\Constraints as UserAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Ath\UserBundle\Model\StatutJuridique;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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
 * @ORM\HasLifecycleCallbacks
 * @UserAssert\ConditionalValidatorForUser
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
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    protected $facebookId;
    
    /** 
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) 
     */
    protected $facebookAccessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", nullable=true)
     */
    protected $googleId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string", nullable=true)
     */
    protected $twitterId;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable = true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="siteweb", type="string", length=255, nullable = true)
     */
    private $siteWeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="datetime", nullable = true)
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
     * @ORM\Column(name="cgu", type="boolean")
     */
    private $cgu = 0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut_juridique", type="integer")
     */
    private $statutJuridique; // 1 = Homme, 2 = Femme, 3 = Association

    /**
     * @ORM\Column(name="date_de_creation", type="datetime", nullable = true)
     */
    private $dateDeCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_celebrite", type="boolean")
     */
    private $isCelebrite = 0;
	
	/**
     * @var ArrayCollection User $posts
     * 
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\Post", mappedBy="createdBy", cascade={"all"})
     */
    private $posts;

    /**
     * @var ArrayCollection User $comments
     * 
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\Comment", mappedBy="createdBy", cascade={"all"})
     */
    private $comments;

    /**
     * @var ArrayCollection User $userEmetteursFollow
     * 
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserFollow", mappedBy="userEmetteur", cascade={"all"})
     */
    private $userEmetteursFollow; // veut suivre

    /**
     * @var ArrayCollection User $userDestinatairesFollow
     * 
     * @ORM\OrderBy({"dateDemande" = "DESC"})
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserFollow", mappedBy="userDestinataire", cascade={"all"})
     */
    private $userDestinatairesFollow;

    /**
     * @var ArrayCollection UserDiscussion $userDiscussionEmetteurs
     *
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserDiscussion", mappedBy="userEmetteur", cascade={"all"})
     */
    private $userDiscussionEmetteurs;

    /**
     * @var ArrayCollection UserDiscussion $userDiscussionEmetteurs
     *
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\UserDiscussion", mappedBy="userDestinataire", cascade={"all"})
     */
    private $userDiscussionDestinataires;

    /**
     * @var ArrayCollection DemandeCelebrites $demandeCelebrites
     * @ORM\OrderBy({"dateDemande" = "DESC"})
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\DemandeCelebrite", mappedBy="createdBy", cascade={"all"})
     */
    private $demandeCelebrites;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\MainBundle\Entity\Sport", cascade={"all"})
     * @ORM\JoinTable(name="user_interet_sport")
     */
    private $userInteretSports;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\MainBundle\Entity\Produit", cascade={"all"})
     * @ORM\JoinTable(name="user_comparateur_produit")
     */
    private $userComparateurProduits;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\MainBundle\Entity\Sport", cascade={"all"})
     * @ORM\JoinTable(name="association_sport")
     */
    private $associationSports;

    /**
     * @var ArrayCollection Produits $produits
     * @ORM\OrderBy({"updatedAt" = "DESC"})
     * 
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\Produit", mappedBy="createdBy", cascade={"all"})
     */
    private $produits; // produits créés par le user

    /**
     * @var \Ath\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="Ath\MainBundle\Entity\UserSetting", cascade={"all"})
     * @ORM\JoinColumn(name="user_setting_id", referencedColumnName="id")
     */
    private $userSetting;

    /**
    * @var ArrayCollection GroupApplications
    * Owning Side
    *
    * @ORM\ManyToMany(targetEntity="Ath\MainBundle\Entity\GroupApplication", mappedBy="users")
    */
    protected $groupApplications;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    public function __construct()
    {
        parent::__construct();
		$this->posts = new ArrayCollection();     
        $this->demandeCelebrites = new ArrayCollection();
        $this->userInteretSports = new ArrayCollection();
        $this->userComparateurProduits = new ArrayCollection();
        $this->associationSports = new ArrayCollection();
        $this->groupApplications = new ArrayCollection();
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
     * Get getFacebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Get setFacebookId
     *
     * @return string 
     */
    public function setFacebookId($facebookId)
    {
        return $this->facebookId = $facebookId;
    }

    /**
     * Get getfacebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Get setfacebookAccessToken
     *
     * @return string 
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        return $this->facebookAccessToken = $facebookAccessToken;
    }

    /**
     * Get getGoogleId
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Get setGoogleId
     *
     * @return string 
     */
    public function setGoogleId($googleId)
    {
        return $this->googleId = $googleId;
    }

    /**
     * Get getTwitterId
     *
     * @return string 
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }
    
    /**
     * Get setTwitterId
     *
     * @return string 
     */
    public function setTwitterId($twitterId)
    {
        return $this->twitterId = $twitterId;
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
     * Set site web
     *
     * @param string $siteWeb
     * @return User
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get Site web
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
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
     * Get the value string of statutJuridique
     *
     * @return mixed
     */
    public function getStatutJuridique()
    {  
        return StatutJuridique::getLibFromId($this->statutJuridique);
    }
    
    /**
     * Get the value of statutJuridique
     *
     * @return mixed
     */
    public function getStatutJuridiqueId()
    {
        return $this->statutJuridique;
    }

    /**
     * Set the value of statutJuridique
     *
     * @param mixed statutJuridique
     *
     * @return self
     */
    public function setStatutJuridique($statutJuridique)
    {
        $this->statutJuridique = $statutJuridique;

        return $this;
    }
    
    /**
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     * @return User
     */
    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    /**
     * Get dateDeCreation
     *
     * @return \DateTime 
     */
    public function getDateDeCreation()
    {
        return $this->dateDeCreation;
    }

    /**
     * Set isCelebrite
     *
     * @param boolean $isCelebrite
     * @return User
     */
    public function setIsCelebrite($isCelebrite)
    {
        $this->isCelebrite = $isCelebrite;

        return $this;
    }

    /**
     * Get isCelebrite
     *
     * @return boolean
     */
    public function getIsCelebrite()
    {
        return (boolean)$this->isCelebrite;
    }

    public function getPosts()
    {
      return $this->posts;
    }
	
	public function removePost(\Ath\MainBundle\Entity\Post $post)
    {
      $this->posts->removeElement($post);
    }
	
	public function addPost(\Ath\MainBundle\Entity\Post $post)
    {
        if (!$this->posts->contains($post))
            $this->posts->add($post);
        
        return $this;
    }
	
    public function getComments()
    {
      return $this->comments;
    }
    
    public function removeComments(\Ath\MainBundle\Entity\Comment $comment)
    {
      $this->comments->removeElement($comment);
    }
    
    public function addComment(\Ath\MainBundle\Entity\Comment $comment)
    {
        if (!$this->comments->contains($comment))
            $this->comments->add($comment);
        
        return $this;
    }

    public function getUserEmetteursFollow()
    {
      return $this->userEmetteursFollow;
    }
    
    public function removeUserEmetteursFollow(\Ath\MainBundle\Entity\UserFollow $userEmetteurFollow)
    {
      $this->userEmetteursFollow->removeElement($userEmetteurFollow);
    }
    
    public function addUserEmetteursFollow(\Ath\MainBundle\Entity\UserFollow $userEmetteurFollow)
    {
        if (!$this->userEmetteursFollow->contains($userEmetteurFollow))
            $this->userEmetteursFollow->add($userEmetteurFollow);
        
        return $this;
    }

    public function getUserDestinatairesFollow()
    {
      return $this->userDestinatairesFollow;
    }
    
    public function removeUserDestinatairesFollow(\Ath\MainBundle\Entity\UserFollow $userDestinataireFollow)
    {
      $this->userDestinatairesFollow->removeElement($userDestinataireFollow);
    }
    
    public function addUserDestinatairesFollow(\Ath\MainBundle\Entity\UserFollow $userDestinataireFollow)
    {
        if (!$this->userDestinatairesFollow->contains($userDestinataireFollow))
            $this->userDestinatairesFollow->add($userDestinataireFollow);
        
        return $this;
    }

    public function getUserDiscussionEmetteurs()
    {
      return $this->userDiscussionEmetteurs;
    }
    
    public function removeUserDiscussionEmetteur(\Ath\MainBundle\Entity\UserDiscussion $userDiscussion)
    {
      $this->userDiscussionEmetteurs->removeElement($userDiscussion);
    }
    
    public function addUserDiscussionEmetteurs(\Ath\MainBundle\Entity\UserDiscussion $userDiscussion)
    {
        if (!$this->userDiscussionEmetteurs->contains($userDiscussion))
            $this->userDiscussionEmetteurs->add($userDiscussion);
        
        return $this;
    }

    public function getUserDiscussionDestinataires()
    {
      return $this->userDiscussionDestinataires;
    }
    
    public function removeUserDiscussionDestinataire(\Ath\MainBundle\Entity\UserDiscussion $userDiscussion)
    {
      $this->userDiscussionDestinataires->removeElement($userDiscussion);
    }
    
    public function addUserDiscussionDestinataire(\Ath\MainBundle\Entity\UserDiscussion $userDiscussion)
    {
        if (!$this->userDiscussionDestinataires->contains($userDiscussion))
            $this->userDiscussionDestinataires->add($userDiscussion);
        
        return $this;
    }

    public function getDemandeCelebrites()
    {
      return $this->demandeCelebrites;
    }

    public function setUserInteretSports($userInteretSports) {

          $this->userInteretSports[] = $userInteretSports;
        return $this;
    }
    /**
     * Add userInteretSports
     *
     * @param \Ath\MainBundle\Entity\Sport $userInteretSport
     * @return User
     */
    public function addUserInteretSport(\Ath\MainBundle\Entity\Sport $userInteretSport) {
        if (!$this->userInteretSports->contains($userInteretSport)) {
          $this->userInteretSports[] = $userInteretSport;
        }
        return $this;
    }

    /**
     * Remove userInteretSports
     *
     * @param \Ath\MainBundle\Entity\Sport $userInteretSport
     */
    public function removeUserInteretSport(\Ath\MainBundle\Entity\Sport $userInteretSport) {
        $this->userInteretSports->removeElement($userInteretSport);
    }

   /**
    * Get userInteretSports
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getUserInteretSports() {
        return $this->userInteretSports;
    }

    /**
     * Add userComparateurProduit
     *
     * @param \Ath\MainBundle\Entity\Produit $produit
     * @return User
     */
    public function addUserComparateurProduit(\Ath\MainBundle\Entity\Produit $produit) {
        if (!$this->userComparateurProduits->contains($produit)) {
          $this->userComparateurProduits[] = $produit;
        }
        return $this;
    }

    /**
     * Remove userComparateurProduit
     *
     * @param \Ath\MainBundle\Entity\Produit $produit
     */
    public function removeUserComparateurProduit(\Ath\MainBundle\Entity\Produit $produit) {
        $this->userComparateurProduits->removeElement($produit);
    }

   /**
    * Get userComparateurProduits
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getUserComparateurProduits() {
        return $this->userComparateurProduits;
    }

    public function setAssociationSports($associationSports) {
          $this->associationSports[] = $associationSports;
        return $this;
    }
    /**
     * Add associationSports
     *
     * @param \Ath\MainBundle\Entity\Sport $userInteretSport
     * @return User
     */
    public function addAssociationSport(\Ath\MainBundle\Entity\Sport $associationSport) {
        if (!$this->associationSports->contains($associationSport)) {
          $this->associationSports[] = $associationSport;
        }
        return $this;
    }

    /**
     * Remove associationSports
     *
     * @param \Ath\MainBundle\Entity\Sport $associationSport
     */
    public function removeAssociationSport(\Ath\MainBundle\Entity\Sport $associationSport) {
        $this->associationSports->removeElement($associationSport);
    }

   /**
    * Get associationSports
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getAssociationSports() {
        return $this->associationSports;
    }

    public function getProduits()
    {
      return $this->produits;
    }
    
    public function removeProduit(\Ath\MainBundle\Entity\Produit $produit)
    {
      $this->produits->removeElement($produit);
    }
    
    public function addProduit(\Ath\MainBundle\Entity\Produit $produit)
    {
        if (!$this->produits->contains($produit))
            $this->produits->add($produit);
        
        return $this;
    }

    /**
     * Set userSetting
     *
     * @param UserSetting $userSetting
     * @return User
     */
    public function setUserSetting($userSetting)
    {
        $this->userSetting = $userSetting;

        return $this;
    }

    /**
     * Get userSetting
     *
     * @return User
     */
    public function getUserSetting()
    {
        return $this->userSetting;
    }  

    public function getRoles()
    {
        $roles = $this->roles;
        if ($this->getGroupApplications()) {
            foreach ($this->getGroupApplications() as $group) {
                $rolesGroup = $group->getRoles();
                $arraydiff = array_diff($rolesGroup, $roles);
                $roles = array_merge($arraydiff, $roles);
            }
        }

        return $roles;
    }

    public function getRolesOnly()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function hasRole($role)
    {
        $role = strtoupper($role);

        if (in_array($role, $this->getRoles())) {
            return true;
        }

        if (in_array('ROLE_SUPER_ADMIN', $this->getRoles())) {
            return true;
        }

        return false;
    }

    /**
     * Get the value of groupApplications
     *
     * @return ArrayCollection groupApplications
     */
    public function getGroupApplications()
    {
        return $this->groupApplications;
    }
    /******* Function pratique **************/

    public function getNomComplet() {
        return ucfirst($this->prenom) . ' ' . ucfirst($this->nom);
    }
	
    public function getAdresse(){
        return $this->rue.' '. $this->cp. ' '. $this->ville;
    }
	public function getPrefixMail($email) {
		list($prefix, $suffixe) = explode('@', $email);
		return $prefix;
	}

    /**
     * Vérifie si l'utilisateur peut faire une demande de célébrité
     * @return boolean
     */
    public function canDemandeCelebrite()
    {
        $ok = false;

        $demandeCelebrites = $this->getDemandeCelebrites();
        if($this->statutJuridique < 3)
        {
            if(!$this->hasRole("ROLE_CELEBRITE"))
            {
                if(count($demandeCelebrites) == 0)
                    $ok=true;
                else {
                    $lastDemande = $demandeCelebrites[0];
                
                    $dateDemande = $lastDemande->getDateDemande();

                    $dateAutoriser = new \DateTime($dateDemande->format('Y-m-d'));
                    $dateAutoriser->add(new \DateInterval('P30D'));
                    $now = new \DateTime();
                    // le user peut refaire une demande 30j après sa dernière demande
                    if($now > $dateAutoriser)
                        $ok = true;
                }
            }
        }

        return $ok;
    }

    /**
     * Gets the value of slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /********* Fin function pratique **********/

    /*** GESTION UPLOADS photo de profile ***/

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
        return '/uploads/profil';
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


    public function __toString() {
      return $this->getNomComplet();
    }
}
