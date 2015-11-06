<?php

namespace ApplicationBundle\Entity;
use Ramsey\Uuid\Uuid;

/**
 * Class SimpleTodo
 * @package ApplicationBundle\Entity
 */
class SimpleTodo
{

    const STATUS_TODO = 0;
    const STATUS_DONE = 1;

    protected $identifier;
    protected $name;
    protected $description;
    protected $status;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->identifier = Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    /**
     * @param $name
     * @param $description
     * @return SimpleTodo
     */
    public static function createTodo($name, $description)
    {
        $self = new self;
        $self->name = $name;
        $self->description = $description;
        $self->createdAt = new \DateTime('now');
        $self->status = self::STATUS_TODO;

        return $self;
    }

    public function __toString()
    {
        return $this->name;
    }

}