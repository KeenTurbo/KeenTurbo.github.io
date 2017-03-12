<?php

namespace GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 *
 * @ORM\Table(name="cshome_topic")
 * @ORM\Entity(repositoryClass="GroupBundle\Repository\TopicRepository")
 */
class Topic
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
        $this->numComments = 0;
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
