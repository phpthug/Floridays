<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Owner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ParamountHOA\ParamountHoaEntityBundle\Entity\OwnerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Owner
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="owner", cascade="persist")
     */
    protected $units;

    /**
    * @var string
    *
    * @ORM\Column(name="phoneNumber", length=12)
    */
    protected $phoneNumber;
    
    /**
     * @ORM\OneToOne(targetEntity="Address", cascade="persist")
     * @ORM\JoinColumn(name="addressId", referencedColumnName="id")
     */
    protected $address;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", cascade="persist")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    protected $user;

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

    public function __construct() 
    {
        $this->units = new ArrayCollection();
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
     * Add units
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Unit $units
     * @return Owner
     */
    public function addUnit(\ParamountHOA\ParamountHoaEntityBundle\Entity\Unit $units)
    {
        $this->units[] = $units;
    
        return $this;
    }

    /**
     * Remove units
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Unit $units
     */
    public function removeUnit(\ParamountHOA\ParamountHoaEntityBundle\Entity\Unit $units)
    {
        $this->units->removeElement($units);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Set address
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Address $address
     * @return Owner
     */
    public function setAddress(\ParamountHOA\ParamountHoaEntityBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \ParamountHOA\ParamountHoaEntityBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     * @return Owner
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    
        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Owner
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Owner
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set user
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\User $user
     * @return Owner
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
     * @return Owner
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
     * @return Owner
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

    public function getSerialized()
    {
        $units = [];

        foreach($this->getUnits() as $unit) {
            array_push($units, $unit->getSerialized());
        }

        return [
            'id' => $this->getId(),
            'user' => $this->getUser()->getSerialized(),
            'address' => $this->getAddress()->getSerialized(),
            'units' => $units,
            'phoneNumber' => $this->getPhoneNumber()
        ];
    }
}