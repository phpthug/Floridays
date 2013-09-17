<?php

namespace ParamountHOA\ParamountHoaEntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="ParamountHOA\ParamountHoaEntityBundle\Entity\DocumentRepository")
 */
class Document
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = false;

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
     * @var Property
     *
     * @ORM\Column(name="property", type="string", length=1)
     */
    protected $property;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;


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
     * Set description
     *
     * @param string $description
     * @return Entity
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Entity
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Entity
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    
        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean 
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Entity
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
     * @return Entity
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
     * Set property
     *
     * @param string $property
     * @return Document
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
     * Set type
     *
     * @param integer $type
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get serialized document
     *
     * @return array
     */
    public function getSerialized()
    {
        return [
                'id' => $this->getId(),
                'path' => $this->getPath(),
                'created' => $this->getCreatedAt(),
                'archived' => $this->getArchived(),
                'type' => $this->getType(),
                'description' => $this->getDescription()
        ];
    }
}