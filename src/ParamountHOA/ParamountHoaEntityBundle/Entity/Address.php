<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Address
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
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="suite", type="string", length=255)
     */
    private $suite;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=35)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=2)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=11)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    public $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdated", type="datetime")
     */
    public $lastUpdated;


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
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set suite
     *
     * @param string $suite
     * @return Address
     */
    public function setSuite($suite)
    {
        $this->suite = $suite;
    
        return $this;
    }

    /**
     * Get suite
     *
     * @return string 
     */
    public function getSuite()
    {
        return $this->suite;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    
        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
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
     * @return Address
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
     * @return Address
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
     * Serialize address as array
     *
     * @return array
     */
    public function getSerialized()
    {
        return [
            'id' => $this->getId(),
            'street' => $this->getStreet(),
            'suite' => $this->getSuite(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'zipCode' => $this->getZipCode(),
            'country' => $this->getCountry()
        ];
    }
}