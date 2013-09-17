<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Admin
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", cascade="persist")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isSuperAdmin", type="boolean")
     */
    protected $isSuperAdmin = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdated", type="datetime")
     */
    protected $lastUpdated;


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
     * Set user
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\User $user
     * @return Admin
     */
    public function setUser(\ParamountHOA\ParamountHoaEntityBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \ParamountHOA\ParamountHoaEntityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
        }

        if(is_null($this->getLastUpdated())) {
            $this->setLastUpdated(new \DateTime());
        }

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setLastUpdated(new \DateTime());

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Admin
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
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     * @return Admin
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    
        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime 
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set isSuperAdmin
     *
     * @param boolean $isSuperAdmin
     * @return Admin
     */
    public function setIsSuperAdmin($isSuperAdmin)
    {
        $this->isSuperAdmin = $isSuperAdmin;
    
        return $this;
    }

    /**
     * Get isSuperAdmin
     *
     * @return boolean 
     */
    public function getIsSuperAdmin()
    {
        return $this->isSuperAdmin;
    }

    public function getSerialized()
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser()->getSerialized(),
            'isSuperAdmin' => $this->getIsSuperAdmin()
        ];
    }
}