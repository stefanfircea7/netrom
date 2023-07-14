<?php

namespace App\Controller;
use App\Entity\Game;

use App\Entity\FormGameResults;
use App\Entity\Result;
use App\Form\ResultType;
use App\Repository\ResultRepository;
use ContainerXiXz4Xk\getFormGameResultsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/result')]
class ResultController extends AbstractController
{
    #[Route('/', name: 'app_result_index', methods: ['GET'])]
    public function index(ResultRepository $resultRepository): Response
    {
        $groupedResults=$resultRepository->findResultsGroupedByGameId();

        return $this->render('result/index.html.twig', [
            'groupedResults' => $groupedResults,
        ]);
    }

    #[Route('/new', name: 'app_result_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ResultRepository $resultRepository): Response
    {
        $result = new FormGameResults();
        $result_home=new Result();
        $result_away=new Result();
        $form = $this->createForm(ResultType::class, $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result_home ->setGameID($result->gameid);
            $result_home ->setConceded($result->awayscored);
            $result_home ->setScored($result->homescored);
            $result_home -> setTeamID($result->hometeam);
            if($result ->homescored > $result ->awayscored)
            {
                $result_home -> setPoints(3);
            }
            elseif ($result ->homescored < $result ->awayscored)
            {
                $result_home -> setPoints(0);
            }
            else{
                $result_home -> setPoints(1);
            }

            $resultRepository->save($result_home, true);

            $result_away ->setGameID($result->gameid);
            $result_away ->setConceded($result->homescored);
            $result_away ->setScored($result->awayscored);
            $result_away -> setTeamID($result->awayteam);
            if($result ->homescored > $result ->awayscored)
            {
                $result_away -> setPoints(0);
            }
            elseif ($result ->homescored < $result ->awayscored)
            {
                $result_away -> setPoints(3);
            }
            else{
                $result_away -> setPoints(1);
            }

            $resultRepository->save($result_away, true);

            return $this->redirectToRoute('app_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('result/new.html.twig', [
            'result' => $result,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_result_show', methods: ['GET'])]
    public function show(Result $result): Response
    {
        return $this->render('result/show.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_result_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $id, ResultRepository $resultRepository): Response
    {
        $result=new FormGameResults();
        $result ->gameid=$id;
        $gameResults = $resultRepository->findBy(['game' => $id]);

        $ht = null;
        $at = null;

        foreach ($gameResults as $gr) {
            if ($ht === null) {
                $ht = $gr;
            } elseif ($at === null) {
                $at = $gr;
                break;
            }
        }

        $form = $this->createForm(ResultType::class, $result);
        $disableFields = ['awayteam', 'hometeam', 'gameid'];


        foreach ($disableFields as $fieldName) {
            $form->add($fieldName, null, ['disabled' => true]);
        }
        $form->get('awayteam')->setData($at->getTeamID());
        $form->get('hometeam')->setData($ht->getTeamID());
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $result_home = $ht;
            $result_away = $at;

            $result_home ->setGameID($result->gameid);
            $result_home ->setConceded($result->awayscored);
            $result_home ->setScored($result->homescored);

            if($result ->homescored > $result ->awayscored)
            {
                $result_home -> setPoints(3);
            }
            elseif ($result ->homescored < $result ->awayscored)
            {
                $result_home -> setPoints(0);
            }
            else{
                $result_home -> setPoints(1);
            }

            $resultRepository->save($result_home, true);

            $result_away ->setGameID($result->gameid);
            $result_away ->setConceded($result->homescored);
            $result_away ->setScored($result->awayscored);

            if($result ->homescored > $result ->awayscored)
            {
                $result_away -> setPoints(0);
            }
            elseif ($result ->homescored < $result ->awayscored)
            {
                $result_away -> setPoints(3);
            }
            else{
                $result_away -> setPoints(1);
            }

            $resultRepository->save($result_away, true);

            return $this->redirectToRoute('app_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('result/edit.html.twig', [
            'result' => $result,
            'form' => $form,

        ]);
    }


    #[Route('/{id}', name: 'app_result_delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, ResultRepository $resultRepository): Response
    {
        $results = $resultRepository->findBy(['game' => $game]);

        if (!empty($results)) {
            foreach ($results as $result) {
                $resultRepository->remove($result, true);
            }
        }

        return $this->redirectToRoute('app_result_index', [], Response::HTTP_SEE_OTHER);
    }

}
