<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
 * @ORM\HasLifecycleCallbacks()
 */
class Unit {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\Column(type="string", length=12)
    */
	protected $unitNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="units", cascade="persist")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="id")
     */
    protected $owner;

    /**
    * @ORM\Column(type="string", length=15)
    */
    protected $contractNumber;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="unit")
     */
    protected $reservations;

    /**
     * @var Property
     *
     * @ORM\Column(name="property", type="string", length=1)
     */
    protected $property;

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
     * Set unitNumber
     *
     * @param string $unitNumber
     * @return Unit
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;
    
        return $this;
    }

    /**
     * Get unitNumber
     *
     * @return string 
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }

    /**
     * Set owner
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Owner $owner
     * @return Unit
     */
    public function setOwner(\ParamountHOA\ParamountHoaEntityBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \ParamountHOA\ParamountHoaEntityBundle\Entity\Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set contractNumber
     *
     * @param string $contractNumber
     * @return Unit
     */
    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;
    
        return $this;
    }

    /**
     * Get contractNumber
     *
     * @return string 
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    /**
     * Add reservations
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Reservation $reservations
     * @return Unit
     */
    public function addReservation(\ParamountHOA\ParamountHoaEntityBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
    
        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\ParamountHOA\ParamountHoaEntityBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Unit
     */
    public function setProperty($property)
    {
        $this->property = $property;
    
        return $this;
    }

    /**
     * Get property
     *
     * @return string 
     */
    public function getProperty()
    {
        return $this->property;
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
     * @return Unit
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
     * @return Unit
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
        return [
            'id' => $this->getId(),
            'unitNumber' => $this->getUnitNumber(),
            'contractNumber' => $this->getContractNumber(),
            'owner' => $this->getOwner()->getId()
        ];
    }
}