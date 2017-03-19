<?php

namespace GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 *
 * @ORM\Table(name="cshome_topic", indexes={@Index(columns={"deleted_at", "touched_at"})})
 * @ORM\Entity(repositoryClass="GroupBundle\Repository\TopicRepository")
 */
class Topic
{
    const NUM_ITEMS = 20;

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
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="请输入标题")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="请输入内容")
     * @Assert\Length(
     *     min="5",
     *     max="10000",
     *     minMessage="内容至少 {{ limit }} 个字符",
     *     maxMessage="内容不能超过 {{ limit }} 个字符"
     * )
     */
    private $body;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numViews;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numComments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $touchedAt;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="GroupBundle\Entity\Group")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Topic constructor.
     */
    public function __construct()
    {
        $this->numViews = 0;
        $this->numComments = 0;
        $this->createdAt = new \DateTime();
        $this->touchedAt = new \DateTime();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumViews()
    {
        return $this->numViews;
    }

    /**
     * @param int $numViews
     *
     * @return self
     */
    public function setNumViews($numViews)
    {
        $this->numViews = intval($numViews);

        return $this;
    }

    /**
     * @param int $by
     *
     * @return int
     */
    public function incrementNumViews($by = 1)
    {
        return $this->numViews += intval($by);
    }

    /**
     * @return int
     */
    public function getNumComments()
    {
        return $this->numComments;
    }

    /**
     * @param int $numComments
     *
     * @return self
     */
    public function setNumComments($numComments)
    {
        $this->numComments = intval($numComments);

        return $this;
    }

    /**
     * @param int $by
     *
     * @return int
     */
    public function incrementNumComments($by = 1)
    {
        return $this->numComments += intval($by);
    }

    /**
     * @param int $by
     *
     * @return int
     */
    public function decrementNumComments($by = 1)
    {
        return $this->numComments -= intval($by);
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
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     *
     * @return self
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTouchedAt()
    {
        return $this->touchedAt;
    }

    /**
     * @param \DateTime $touchedAt
     *
     * @return self
     */
    public function setTouchedAt(\DateTime $touchedAt)
    {
        $this->touchedAt = $touchedAt;

        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     *
     * @return self
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
