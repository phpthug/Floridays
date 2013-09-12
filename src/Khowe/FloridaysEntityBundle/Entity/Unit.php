<?php

namespace Khowe\FloridaysEntityBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
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
     * @param \Khowe\FloridaysEntityBundle\Entity\Owner $owner
     * @return Unit
     */
    public function setOwner(\Khowe\FloridaysEntityBundle\Entity\Owner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Khowe\FloridaysEntityBundle\Entity\Owner 
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
     * @param \Khowe\FloridaysEntityBundle\Entity\Reservation $reservations
     * @return Unit
     */
    public function addReservation(\Khowe\FloridaysEntityBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
    
        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Khowe\FloridaysEntityBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\Khowe\FloridaysEntityBundle\Entity\Reservation $reservations)
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
}