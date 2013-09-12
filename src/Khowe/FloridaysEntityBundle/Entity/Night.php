<?php

namespace Khowe\FloridaysEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Night
 * @package Khowe\FloridaysEntityBundle\Entity
 * @author  Kenneth Howe <knnth.howe@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Night {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="night")
     */
    protected $reservations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservationDate", type="datetime")
     */
    protected $reservationDate;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }


    /**
     * Add reservations
     *
     * @param \Khowe\FloridaysEntityBundle\Entity\Reservation $reservations
     * @return Night
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reservationDate
     *
     * @param \DateTime $reservationDate
     * @return Night
     */
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;
    
        return $this;
    }

    /**
     * Get reservationDate
     *
     * @return \DateTime 
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }
}