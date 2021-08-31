<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 * @ORM\Table(name="items",indexes={@ORM\Index(name="search_idx", columns={"name", "completed"})})
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $completed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completed_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getCompletedAt(): ?\DateTime
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?\DateTime $completed_at): self
    {
        $this->completed_at = $completed_at;

        return $this;
    }

    public function getCompletedStatus(): string
    {
        $isCompleted = $this->getCompleted();
        if ($isCompleted) {
            return 'Completed';
        }

        return 'In progress';
    }

    public function getCompletedAtDate()
    {
        if ($this->getCompletedAt())
            return date_format($this->getCompletedAt(), 'Y-m-d H:i');

        return '';
    }
}
