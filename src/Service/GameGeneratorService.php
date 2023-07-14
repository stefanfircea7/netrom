<?php
namespace App\Service;

use App\Entity\Game;
use App\Entity\Result;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

class GameGeneratorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateGamesWithResults(
        \DateTimeInterface $startDate,
        int $durationInDays,
        \DateTimeInterface $startTime,
        \DateTimeInterface $endTime,
        int $gameLengthMinutes
    ): void {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();
        $totalTeams = count($teams);
        $breakBetweenGames = 10;
        $playedTeams = [];

        $currentDate = $startDate;
        $currentTime = clone $startTime;

        foreach ($teams as $homeTeam) {
            foreach ($teams as $awayTeam) {
                if ($homeTeam === $awayTeam || isset($playedTeams[$homeTeam->getId()][$awayTeam->getId()])) {
                    continue;
                }
                if($currentTime > $endTime){
                    $currentTime = clone $startTime;
                    $currentDate = $currentDate->add(new \DateInterval('P1D'));
                }
                $gameStartTime = clone $currentTime;
                $gameStartTime->setTime($currentTime->format('H'), $currentTime->format('i'));

                $gameEndTime = clone $gameStartTime;
                $gameEndTime->modify('+' . $gameLengthMinutes . ' minutes');

                var_dump($gameStartTime);
                var_dump($gameEndTime);
                $game = new Game();
                $game->setStartDate($currentDate);
                $game->setTime($gameStartTime);

                $homeResult = new Result();
                $homeResult->setTeamID($homeTeam);
                $game->setHomeResult($homeResult);

                $awayResult = new Result();
                $awayResult->setTeamID($awayTeam);
                $game->setAwayResult($awayResult);

                $this->entityManager->persist($game);
                $this->entityManager->persist($homeResult);
                $this->entityManager->persist($awayResult);

                $playedTeams[$homeTeam->getId()][$awayTeam->getId()] = true;
                $playedTeams[$awayTeam->getId()][$homeTeam->getId()] = true;

                $currentTime = $currentTime->add(new \DateInterval('PT' . $gameLengthMinutes . 'M'));
                $currentTime = $currentTime->add(new \DateInterval('PT' . $breakBetweenGames . 'M'));


            }

        }

        $this->entityManager->flush();
    }


}