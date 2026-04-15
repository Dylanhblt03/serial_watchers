<?php

namespace App\Entity;

use App\Repository\DirectorRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['director:collection']]),
        new Get(normalizationContext: ['groups' => ['director:read']]),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['nationality' => 'partial'])]
#[ORM\Entity(repositoryClass: DirectorRepository::class)]
class Director
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['director:collection', 'director:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Groups(['director:collection', 'director:read', 'movie:collection', 'movie:read'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Groups(['director:collection', 'director:read', 'movie:collection', 'movie:read'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['director:collection', 'director:read'])]
    private ?string $nationality = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\OneToMany(targetEntity: Movie::class, mappedBy: 'director')]
    #[Groups(['director:collection', 'director:read'])]
    private Collection $director;

    public function __construct()
    {
        $this->director = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getDirector(): Collection
    {
        return $this->director;
    }

    public function addDirector(Movie $director): static
    {
        if (!$this->director->contains($director)) {
            $this->director->add($director);
            $director->setDirector($this);
        }

        return $this;
    }

    public function removeDirector(Movie $director): static
    {
        if ($this->director->removeElement($director)) {
            // set the owning side to null (unless already changed)
            if ($director->getDirector() === $this) {
                $director->setDirector(null);
            }
        }

        return $this;
    }
}
