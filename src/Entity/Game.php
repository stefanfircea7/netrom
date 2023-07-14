<?php

namespace App\Entity;
use App\Entity\Result;
use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $StartDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\ManyToOne(inversedBy: 'GamesWon')]
    private ?Team $WinnerID = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Result", cascade={"persist"})
     * @ORM\JoinColumn(name="home_result_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ?Result $homeResult = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Result", cascade={"persist"})
     * @ORM\JoinColumn(name="away_result_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ?Result $awayResult = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(\DateTimeInterface $StartDate): static
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getWinnerID(): ?Team
    {
        return $this->WinnerID;
    }

    public function setWinnerID(?Team $WinnerID): static
    {
        $this->WinnerID = $WinnerID;

        return $this;
    }
    public function __toString()
    {
        return (string) $this-> getId();
    }


    public function getHomeResult(): ?Result
    {
        return $this->homeResult;
    }

    public function setHomeResult(?Result $homeResult): self
    {
        $this->homeResult = $homeResult;
        $homeResult->setGameID($this);

        return $this;
    }

    public function getAwayResult(): ?Result
    {
        return $this->awayResult;
    }

    public function setAwayResult(?Result $awayResult): self
    {
        $this->awayResult = $awayResult;
        $awayResult->setGameID($this);

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @param \DateTimeInterface|null $time
     */
    public function setTime(?\DateTimeInterface $time): void
    {
        $this->time = $time;
    }
}
