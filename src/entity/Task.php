<?php

namespace app\entity;

use DateTime;
use Doctrine\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(
 *     repositoryClass="\app\repositories\TaskRepository"
 * )
 * @Table(
 *     name="task",
 *     indexes={
 *          @Index(name="status_idx", columns={"status"})
 *     }
 * )
 */
class Task
{
    const STATUS_ACTIVE = 1;
    const STATUS_DONE = 0;

    /**
     * @Id()
     * @Column(type="bigint")
     * @GeneratedValue()
     * @var int
     */
    protected $id;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $text;

    /**
     * @Column(type="smallint")
     * @var int
     */
    protected $status = 1;

    /**
     * @Column(
     *     type="datetime",
     *     options={"default": "CURRENT_TIMESTAMP"}
     * )
     * @var DateTime
     */
    protected $created;

    /**
     * @ManyToOne(
     *     targetEntity="User",
     *     inversedBy="tasks"
     * )
     */
    protected $user;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->created = new DateTime();
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $user->addTask($this);
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserName(): string
    {
        return $this->getUser()->getName();
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->getUser()->getEmail();
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }
}
