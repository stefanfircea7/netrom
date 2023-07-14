<?php


namespace App\Controller;
use App\Repository\TeamRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(TeamRepository $teamRepository): Response
    {
        $teamStatistics = $teamRepository->getTeamStatistics();

        return $this->render('base.html.twig', [
            'teamStatistics' => $teamStatistics,
        ]);
    }
}
