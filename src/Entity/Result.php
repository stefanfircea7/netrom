<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Game;
#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(name: 'game_id', referencedColumnName: 'id')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'GetResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $TeamID = null;

    #[ORM\Column(nullable: true)]
    private ?int $Points = null;

    #[ORM\Column(nullable: true)]
    private ?int $Scored = null;

    #[ORM\Column(nullable: true)]
    private ?int $Conceded = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameID(): ?Game
    {
        return $this->game;
    }

    public function setGameID(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getTeamID(): ?Team
    {
        return $this->TeamID;
    }

    public function setTeamID(?Team $TeamID): static
    {
        $this->TeamID = $TeamID;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->Points;
    }

    public function setPoints(int $Points): static
    {
        $this->Points = $Points;

        return $this;
    }

    public function getScored(): ?int
    {
        return $this->Scored;
    }

    public function setScored(?int $Scored): static
    {
        $this->Scored = $Scored;

        return $this;
    }

    public function getConceded(): ?int
    {
        return $this->Conceded;
    }

    public function setConceded(?int $Conceded): static
    {
        $this->Conceded = $Conceded;

        return $this;
    }
}
