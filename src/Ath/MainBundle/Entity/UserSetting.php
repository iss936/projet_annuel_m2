<?php

namespace Ath\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSetting
 *
 * @ORM\Table(name="user_setting")
 * @ORM\Entity(repositoryClass="Ath\MainBundle\Repository\UserSettingRepository")
 */
class UserSetting
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
     * @var bool
     *
     * @ORM\Column(name="auto_follow", type="boolean")
     */
    private $autoFollow = 1;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter = 1;

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
     * Set autoFollow
     *
     * @param boolean $autoFollow
     * @return UserSetting
     */
    public function setAutoFollow($autoFollow)
    {
        $this->autoFollow = $autoFollow;

        return $this;
    }

    /**
     * Get autoFollow
     *
     * @return boolean 
     */
    public function getAutoFollow()
    {
        return $this->autoFollow;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     * @return UserSetting
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
