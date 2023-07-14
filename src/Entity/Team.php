<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $Pcount = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 50)]
    private ?string $Color = null;

    #[ORM\OneToMany(mappedBy: 'WinnerID', targetEntity: Game::class)]
    private Collection $GamesWon;

    #[ORM\OneToMany(mappedBy: 'TeamID', targetEntity: Result::class, orphanRemoval: true)]
    private Collection $GetResults;

    public function __construct()
    {
        $this->GamesWon = new ArrayCollection();
        $this->GetResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPcount(): ?int
    {
        return $this->Pcount;
    }

    public function setPcount(int $Pcount): static
    {
        $this->Pcount = $Pcount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(string $Color): static
    {
        $this->Color = $Color;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGamesWon(): Collection
    {
        return $this->GamesWon;
    }

    public function addGamesWon(Game $gamesWon): static
    {
        if (!$this->GamesWon->contains($gamesWon)) {
            $this->GamesWon->add($gamesWon);
            $gamesWon->setWinnerID($this);
        }

        return $this;
    }

    public function removeGamesWon(Game $gamesWon): static
    {
        if ($this->GamesWon->removeElement($gamesWon)) {
            // set the owning side to null (unless already changed)
            if ($gamesWon->getWinnerID() === $this) {
                $gamesWon->setWinnerID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getGetResults(): Collection
    {
        return $this->GetResults;
    }

    public function addGetResult(Result $getResult): static
    {
        if (!$this->GetResults->contains($getResult)) {
            $this->GetResults->add($getResult);
            $getResult->setTeamID($this);
        }

        return $this;
    }

    public function removeGetResult(Result $getResult): static
    {
        if ($this->GetResults->removeElement($getResult)) {
            // set the owning side to null (unless already changed)
            if ($getResult->getTeamID() === $this) {
                $getResult->setTeamID(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
}
