<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Wenming Tang <wenming@cshome.com>
 *
 * @ORM\Table(name="cshome_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity("username", message="用户名不可用", groups={"registration"})
 */
class User implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message="请输入用户名",
     *     groups={"registration"}
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="用户名长度不能少于 {{ limit }} 个字符",
     *     max="20",
     *     maxMessage="用户名长度不能大于 {{ limit }} 个字符",
     *     groups={"registration"}
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z0-9][a-z0-9_]+[a-z0-9]$/i",
     *     message="用户名只能包含字母、数字、下划线，但不能以下划线开头和结尾",
     *     groups={"registration"}
     * )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="请输入密码",
     *     groups={"registration", "change_password"}
     * )
     * @Assert\Length(
     *     min="5",
     *     minMessage="密码长度不能少于 {{ limit }} 个字符",
     *     groups={"registration", "change_password"}
     * )
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="名字不能为空",
     *     groups={"profile_edit"}
     * )
     * @Assert\Length(
     *     min="2",
     *     minMessage="名字长度不能少于 {{ limit }} 个字符",
     *     max="20",
     *     maxMessage="名字长度不能大于 {{ limit }} 个字符",
     *     groups={"profile_edit"}
     * )
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numTopics;

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
     * User constructor.
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(mt_rand(), true));
        $this->roles = [];
        $this->numTopics = 0;
        $this->numComments = 0;
        $this->enabled = true;
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
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
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
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === self::ROLE_USER) {
            return $this;
        }
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->platPassword = null;
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
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return self
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
