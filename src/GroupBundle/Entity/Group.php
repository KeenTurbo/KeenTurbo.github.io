<?php

namespace GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Wenming Tang <wenming@cshome.com>
 *
 * @ORM\Table(name="cshome_group")
 * @ORM\Entity(repositoryClass="GroupBundle\Repository\GroupRepository")
 */
class Group
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numTopics;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->numTopics = 0;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumTopics()
    {
        return $this->numTopics;
    }

    /**
     * @param int $numTopics
     *
     * @return self
     */
    public function setNumTopics($numTopics)
    {
        $this->numTopics = intval($numTopics);

        return $this;
    }

    /**
     * @param int $by
     *
     * @return int
     */
    public function incrementNumTopics($by = 1)
    {
        return $this->numTopics += intval($by);
    }

    /**
     * @param int $by
     *
     * @return int
     */
    public function decrementNumTopics($by = 1)
    {
        return $this->numTopics -= intval($by);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}