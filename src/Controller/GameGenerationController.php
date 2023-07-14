<?php

// src/Controller/GameGenerationController.php

namespace App\Controller;
use DateTimeImmutable;

use App\Service\GameGeneratorService;
use App\Form\GameGenerationType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class GameGenerationController extends AbstractController
{
    /**
     * @Route("/generate-games", methods={"POST"})
     */
    public function generateGames(Request $request, GameGeneratorService $gameGeneratorService): Response
    {
        $form = $this->createForm(GameGenerationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = \DateTimeImmutable::createFromMutable($data['startDate']);
            $durationInDays = $data['durationInDays'];
            $startTime = \DateTimeImmutable::createFromFormat('H:i', $data['startTime']->format('H:i'));
            $endTime = \DateTimeImmutable::createFromFormat('H:i', $data['endTime']->format('H:i'));

            $gameLengthMinutes = $data['gameLengthMinutes'];

            $gameGeneratorService->generateGamesWithResults($startDate, $durationInDays, $startTime, $endTime, $gameLengthMinutes);

            return new JsonResponse(['message' => 'Games generated successfully!'], 200);
        }

        return $this->render('others/gamegeneration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
