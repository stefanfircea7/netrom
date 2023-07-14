<?php

namespace App\Form;
use App\Entity\FormGameResults;
use App\Entity\Game;
use App\Entity\Team;
use App\Repository\GameRepository;
use App\Repository\ResultRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class
ResultType extends AbstractType
{
    private $gameRepository;
    private $resultRepository;

    public function __construct(GameRepository $gameRepository, ResultRepository $resultRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->resultRepository = $resultRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hometeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ])
            ->add('homescored', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Only numbers are allowed.',
                    ]),
                ],
            ])
            ->add('awayscored', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Only numbers are allowed.',
                    ]),
                ],
            ])
            ->add('awayteam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(),
                    new Callback([
                        'callback' => [$this, 'validateAwayTeam'],
                    ]),
                ],
            ])
            ->add('gameid', EntityType::class, [
                'class' => Game::class,
                'choices' => $this->getAvailableGames(),
                'choice_label' => function (Game $game) {
                    return $game->getStartDate()->format('Y-m-d');
                },
            ]);

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormGameResults::class,
        ]);
    }
    private function getAvailableGames(): array
    {
        $existingResults = $this->resultRepository->findAll();

        $existingGameIds = [];
        foreach ($existingResults as $existingResult) {
            $existingGameIds[] = $existingResult->getGameID();
        }

        $availableGames = $this->gameRepository->createQueryBuilder('g')
            ->where('g.id NOT IN (:existingGameIds)')
            ->setParameter('existingGameIds', $existingGameIds)
            ->getQuery()
            ->getResult();

        return $availableGames;
    }
    public function validateAwayTeam($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();

        $hometeam = $form['hometeam']->getData();
        $awayteam = $value;

        if ($hometeam === $awayteam) {
            $context->buildViolation('Home team and away team must be different.')
                ->atPath('awayteam')
                ->addViolation();
        }
    }
}
