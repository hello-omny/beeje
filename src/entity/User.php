<?php

namespace app\entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(
 *     repositoryClass="\app\repositories\UserRepository"
 * )
 * @Table(
 *     name="user",
 *     indexes={
 *          @Index(name="email_idx", columns={"email"}),
 *     }
 * )
 */
class User
{
    /**
     * @Id()
     * @Column(type="bigint")
     * @GeneratedValue()
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @Column(
     *     type="datetime",
     *     options={"default": "CURRENT_TIMESTAMP"}
     * )
     * @var DateTime
     */
    protected $created;

    /**
     * @OneToMany(
     *     targetEntity="Task",
     *     mappedBy="user"
     * )
     * @var Task[] An ArrayCollection of Task objects
     */
    protected $tasks;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->created = new DateTime();
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}
