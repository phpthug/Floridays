<?php

namespace Khowe\FloridaysEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reservation
 * @package Khowe\FLoridaysEntityBundle\Entity
 * @author  Kenneth Howe <khowe@ea.com>
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Reservation {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="decimal", precision=2, scale=1)
     */
    protected $rate;

    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="nights")
     * @ORM\JoinColumn(name="unitId", referencedColumnName="id")
     */
    protected $unit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actualDate", type="datetime")
     */
    protected $actualDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservedUntil", type="datetime")
     */
    protected $reservedUntil;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isOwnerNight", type="boolean")
     */
    protected $isOwnerNight;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isOccupied", type="boolean")
     */
    protected $isOccupied;

    /**
     * @var Night
     *
     * @ORM\ManyToOne(targetEntity="Night", inversedBy="reservations")
     * @ORM\JoinColumn(name="nightId", referencedColumnName="id")
     */
    protected $night;


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
     * Set rate
     *
     * @param float $rate
     * @return Reservation
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    
        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set actualDate
     *
     * @param \DateTime $actualDate
     * @return Reservation
     */
    public function setActualDate($actualDate)
    {
        $this->actualDate = $actualDate;
    
        return $this;
    }

    /**
     * Get actualDate
     *
     * @return \DateTime 
     */
    public function getActualDate()
    {
        return $this->actualDate;
    }

    /**
     * Set reservedUntil
     *
     * @param \DateTime $reservedUntil
     * @return Reservation
     */
    public function setReservedUntil($reservedUntil)
    {
        $this->reservedUntil = $reservedUntil;
    
        return $this;
    }

    /**
     * Get reservedUntil
     *
     * @return \DateTime 
     */
    public function getReservedUntil()
    {
        return $this->reservedUntil;
    }

    /**
     * Set isOwnerNight
     *
     * @param boolean $isOwnerNight
     * @return Reservation
     */
    public function setIsOwnerNight($isOwnerNight)
    {
        $this->isOwnerNight = $isOwnerNight;
    
        return $this;
    }

    /**
     * Get isOwnerNight
     *
     * @return boolean 
     */
    public function getIsOwnerNight()
    {
        return $this->isOwnerNight;
    }

    /**
     * Set isOccupied
     *
     * @param boolean $isOccupied
     * @return Reservation
     */
    public function setIsOccupied($isOccupied)
    {
        $this->isOccupied = $isOccupied;
    
        return $this;
    }

    /**
     * Get isOccupied
     *
     * @return boolean 
     */
    public function getIsOccupied()
    {
        return $this->isOccupied;
    }

    /**
     * Set unit
     *
     * @param \Khowe\FloridaysEntityBundle\Entity\Unit $unit
     * @return Reservation
     */
    public function setUnit(\Khowe\FloridaysEntityBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return \Khowe\FloridaysEntityBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set night
     *
     * @param \Khowe\FloridaysEntityBundle\Entity\Night $night
     * @return Reservation
     */
    public function setNight(\Khowe\FloridaysEntityBundle\Entity\Night $night = null)
    {
        $this->night = $night;
    
        return $this;
    }

    /**
     * Get night
     *
     * @return \Khowe\FloridaysEntityBundle\Entity\Night 
     */
    public function getNight()
    {
        return $this->night;
    }
}