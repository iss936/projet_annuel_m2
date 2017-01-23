<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

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
     * @var \Ath\UserBundle\Entity\User
     *
	 * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\User",inversedBy="posts")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\FilePost", mappedBy="post", cascade={"persist", "remove"})
     */
    private $filePosts;

    /**
     * @ORM\OrderBy({"createdAt" = "ASC"})
     * @ORM\OneToMany(targetEntity="Ath\MainBundle\Entity\Comment", mappedBy="post", cascade={"persist", "remove"})
     */
    private $comments;


    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
    * @var ArrayCollection User
    * Inverse Side
    *
    * @ORM\ManyToMany(targetEntity="Ath\UserBundle\Entity\User", inversedBy="postLikes")
    * @ORM\JoinTable(name="user_like_post")
    */
    private $userLikes;

    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "L'image ne doit dépasser 5MB.",
     *     mimeTypesMessage = "Seulement les images sont autorisées."
     * )
     */
    public $file;

    public function __construct()
    {
        $this->filePosts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->userLikes = new ArrayCollection();
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
     * Set contenu
     *
     * @param string $contenu
     * @return Post
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
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
     * @return Post
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
     * @param integer $createdBy
     * @return Post
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Get filePosts
     *
     * @return Array collection of filePosts
     */
    public function getFilePosts()
    {
        return $this->filePosts;
    }

    /**
     * Add filePost
     *
     * @param \Ath\MainBundle\Entity\FilePost $filePost
     *
     * @return Produit
     */
    public function addFilePost(\Ath\MainBundle\Entity\FilePost $filePost)
    {
        if (!$this->filePosts->contains($filePost))
            $this->filePosts[] = $filePost;

        return $this;
    }

    /**
     * Remove filePost
     *
     * @param \Ath\MainBundle\Entity\FilePost $filePost
     */
    public function removeFilePost(\Ath\MainBundle\Entity\FilePost $filePost)
    {
        $this->filePosts->removeElement($filePost);
    }

    public function getComments()
    {
      return $this->comments;
    }
    
    public function getTenLastComments()
    {
        $comments = new ArrayCollection();

        $nb = count($this->comments);
        $first = $nb - 10;
        if ($nb >10) {
            for ($i=$first; $i < $nb ; $i++) { 
                $comments[] = $this->comments[$i];
            }
        }
        else // on prend les 10 premier commentaires
            $comments = $this->comments;
        
        return $comments;
    }

    public function removeComment(\Ath\MainBundle\Entity\Comment $comment)
    {
      $this->comments->removeElement($comment);
    }
    
    public function addComment(\Ath\MainBundle\Entity\Comment $comment)
    {
        if (!$this->comments->contains($comment))
            $this->comments->add($comment);
        
        return $this;
    }

    public function getFirstFilePost()
    {
        if(count($this->filePosts) > 0)
            return $this->filePosts[0];

        return null;
    }
    public function __toString()
    {
        return (string)$this->id;
    }

      /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
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

    /**
     * Set parent
     *
     * @param \Ath\MainBundle\Entity\Post $parent
     * @return Post
     */
    public function setParent(\Ath\MainBundle\Entity\Post $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Ath\MainBundle\Entity\Post 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add userLikes
     *
     * @param \Ath\UserBundle\Entity\User $userLike
     * @return Post
     */
    public function addUserLike(\Ath\UserBundle\Entity\User $userLike)
    {
        if (!$this->userLikes->contains($userLike)) {
            $this->userLikes[] = $userLike;
        }

        return $this;
    }

    /**
     * Remove userLikes
     *
     * @param \Ath\UserBundle\Entity\User $userLike
     */
    public function removeUserLike(\Ath\UserBundle\Entity\User $userLike)
    {
        $this->userLikes->removeElement($userLike);
    }

    /**
     * Get userLikes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserLikes()
    {
        return $this->userLikes;
    }

    /**
     * clickLike
     * add or remove a userlike
     * @param \Ath\UserBundle\Entity\Post $user, bool $remove
     * @return Void
     */
    public function clickLike(\Ath\UserBundle\Entity\User $user, $remove) {
        if ($remove == 'true') {
            $this->removeUserLike($user);
        }
        else{
            $this->addUserLike($user);
        }

        // return $ok;
    }

    public function hasUserLike($user)
    {   
        if ($this->userLikes->contains($user)) {
            return true;
        }

        return false;
    }
}
