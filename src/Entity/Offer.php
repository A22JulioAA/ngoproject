<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $init_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finish_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $vacancy = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastUpdate = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'offers')]
    private Collection $category;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $id_organization = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->lastUpdate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getInitDate(): ?\DateTimeInterface
    {
        return $this->init_date;
    }

    public function setInitDate(?\DateTimeInterface $init_date): static
    {
        $this->init_date = $init_date;

        return $this;
    }

    public function getFinishDate(): ?\DateTimeInterface
    {
        return $this->finish_date;
    }

    public function setFinishDate(?\DateTimeInterface $finish_date): static
    {
        $this->finish_date = $finish_date;

        return $this;
    }

    public function getVacancy(): ?int
    {
        return $this->vacancy;
    }

    public function setVacancy(?int $vacancy): static
    {
        $this->vacancy = $vacancy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTimeInterface $lastUpdate): static
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getIdOrganization(): ?Organization
    {
        return $this->id_organization;
    }

    public function setIdOrganization(?Organization $id_organization): static
    {
        $this->id_organization = $id_organization;

        return $this;
    }
}
