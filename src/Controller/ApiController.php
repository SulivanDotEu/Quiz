<?php

namespace App\Controller;


use App\Entity\Answer;
use App\Entity\Player;
use App\Entity\PlayerChoice;
use App\Entity\Question;
use App\Repository\PlayerChoiceRepository;
use App\Repository\PlayerRepository;
use App\Repository\QuestionRepository;
use App\Service\ContextService;
use App\Service\PlayerService;
use App\UI\Context;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api")
 */
class ApiController extends FOSRestController
{

    /** @var PlayerRepository */
    private $playerRepository;

    /** @var PlayerService */
    private $playerService;

    /** @var SessionInterface */
    private $session;

    /** @var QuestionRepository */
    private $questionRepository;

    /** @var PlayerChoiceRepository */
    private $playerChoiceRepository;

    /** @var $contextService */
    private $contextService;

    const PLAYERS_LIST = 'players_list';

    const LAST_PLAYER = 'last_player';

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param PlayerRepository $playerRepository
     * @param Session $session
     * @param QuestionRepository $questionRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                PlayerRepository $playerRepository,
                                SessionInterface $session,
                                QuestionRepository $questionRepository,
                                PlayerChoiceRepository $playerChoiceRepository,
                                ContextService $contextService,
                                PlayerService $playerService)
    {
        $this->entityManager = $entityManager;
        $this->playerRepository = $playerRepository;
        $this->session = $session;
        $this->questionRepository = $questionRepository;
        $this->contextService = $contextService;
        $this->playerService = $playerService;
        $this->playerChoiceRepository = $playerChoiceRepository;
    }


    /**
     * @Route("/context", name="api.context.get")
     */
    public function getContext()
    {
        $player = $this->playerService->getOrCreatePlayer($this->playerService->getLastPlayer());
        $context = $this->contextService->createContext($player);
        return new JsonResponse($context);
    }

    /**
     * @Route("/submit", name="api.context.submit")
     */
    public function submitContext(Request $request)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);

        $content = $request->getContent();
        $context = $serializer->deserialize($content, Context::class, 'json');

        $this->handleContext($context);

        return new JsonResponse($context);
    }


    protected function getLastPlayer()
    {
        return $this->session->get(self::LAST_PLAYER);
    }

    protected function handleContext(Context $context)
    {
        $questions = $this->getQuestions();
        $player = $this->playerService->getOrCreatePlayer($this->playerService->getLastPlayer());
        $answers = $this->getAnswers($player);

        $totalPoints = 0;
        foreach ($context->questions as $uiQuestion) {
            /** @var Question $question */
            $question = $questions[$uiQuestion['id']];
            $userChoice = $this->getOrCreatePlayerChoice($player, $answers, $question, $uiQuestion);

            $isPlayerCorrect = $userChoice->isCorrect();
            $points = $isPlayerCorrect ? $question->getPoint() : 0;
            $totalPoints += $points;
        }

        $player->setPoints($totalPoints);
        $context->points = $totalPoints;
        $this->entityManager->persist($player);
        $this->entityManager->flush();
    }

    /**
     * @param Player $player
     * @param $answers
     * @param Question $question
     * @param $uiQuestion
     * @throws \Doctrine\ORM\ORMException
     *
     */
    public function getOrCreatePlayerChoice(Player $player, $answers, Question $question, $uiQuestion)
    {
        if (isset($answers[$question->getId()])) {
            $choice = $answers[$question->getId()];
        } else {
            $choice = new PlayerChoice();
            $choice->setPlayer($player);
            $choice->setQuestion($question);
        }
        $choice->setConfirmed($uiQuestion['state'] == \App\UI\Question::STATE_CONFIRMED);
        $choice->setAnswer($question->getAnswerById($uiQuestion['selectedAnswer']['id']));

        $this->entityManager->persist($choice);

        return $choice;
    }

    public function getAnswers(Player $player)
    {
        return $this->contextService->getAnswers($player);
    }

    public function getQuestions()
    {
        return $this->contextService->getQuestions();
    }


}