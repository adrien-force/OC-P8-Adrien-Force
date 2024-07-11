<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\OneToOne(mappedBy: 'taskId', cascade: ['persist', 'remove'])]
    private ?Timeslot $timeslot = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Employe $employeId = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Status $statusId = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $projectId = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'tasks')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getTimeslot(): ?Timeslot
    {
        return $this->timeslot;
    }

    public function setTimeslot(Timeslot $timeslot): static
    {
        // set the owning side of the relation if necessary
        if ($timeslot->getTaskId() !== $this) {
            $timeslot->setTaskId($this);
        }

        $this->timeslot = $timeslot;

        return $this;
    }

    public function getEmployeId(): ?Employe
    {
        return $this->employeId;
    }

    public function setEmployeId(?Employe $employeId): static
    {
        $this->employeId = $employeId;

        return $this;
    }

    public function getStatusId(): ?Status
    {
        return $this->statusId;
    }

    public function setStatusId(?Status $statusId): static
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getProjectId(): ?Project
    {
        return $this->projectId;
    }

    public function setProjectId(?Project $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addTask($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeTask($this);
        }

        return $this;
    }
}