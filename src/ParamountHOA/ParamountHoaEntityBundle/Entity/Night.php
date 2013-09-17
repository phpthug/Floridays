<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Night
 * @package ParamountHOA\ParamountHoaEntityBundle\Entity
 * @author  Kenneth Howe <knnth.howe@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
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
        $this->reservations = new ArrayCollection();
    }


    /**
     * Add reservations
     *
     * @param \ParamountHOA\ParamountHoaEntityBundle\Entity\Reservation $reservations
     * @return Night
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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
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
     * @return Night
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
     * @return Night
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
}