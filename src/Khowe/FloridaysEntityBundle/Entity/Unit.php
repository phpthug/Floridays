<?php

namespace Khowe\FloridaysEntityBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="Owner", inversedBy="units")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="id")
     */
    protected $owner;

    /**
    * @ORM\Column(type="string", length=15)
    */
    protected $contractNumber;


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
}