<?php

namespace Khowe\FloridaysEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Owner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Khowe\FloridaysEntityBundle\Entity\OwnerRepository")
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
     * @param \Khowe\FloridaysEntityBundle\Entity\Unit $units
     * @return Owner
     */
    public function addUnit(\Khowe\FloridaysEntityBundle\Entity\Unit $units)
    {
        $this->units[] = $units;
    
        return $this;
    }

    /**
     * Remove units
     *
     * @param \Khowe\FloridaysEntityBundle\Entity\Unit $units
     */
    public function removeUnit(\Khowe\FloridaysEntityBundle\Entity\Unit $units)
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
     * @param \Khowe\FloridaysEntityBundle\Entity\Address $address
     * @return Owner
     */
    public function setAddress(\Khowe\FloridaysEntityBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return \Khowe\FloridaysEntityBundle\Entity\Address 
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
     * @param \Khowe\FloridaysEntityBundle\Entity\User $user
     * @return Owner
     */
    public function setUser(\Khowe\FloridaysEntityBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Khowe\FloridaysEntityBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}