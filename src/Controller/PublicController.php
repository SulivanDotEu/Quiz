<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Player;
use App\Entity\Question;
use App\Repository\PlayerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{
    /** @var PlayerRepository */
    private $playerRepository;

    /** @var SessionInterface */
    private $session;

    /** @var QuestionRepository */
    private $questionRepository;

    const PLAYERS_LIST = 'players_list';

    const LAST_PLAYER = 'last_player';

    /**
     * @param PlayerRepository $playerRepository
     * @param Session $session
     * @param QuestionRepository $questionRepository
     */
    public function __construct(PlayerRepository $playerRepository, SessionInterface $session, QuestionRepository $questionRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->session = $session;
        $this->questionRepository = $questionRepository;
    }


    /**
     * @Route("/play", name="play")
     */
    public function play(Request $request)
    {
        $player = $this->getOrCreatePlayer($this->getLastPlayer());

        return $this->render('public/play.html.twig', [
            'player'  => $player,
            'context' => $this->createGameContext($player),
        ]);
    }

    public function createGameContext(Player $player)
    {
        $questions = $this->questionRepository->findBy(['active' => true]);
        $context = array_map(function(Question $question) use ($player){
            return [
                'id' => $question->getId(),
                'label' => $question->getLabel(),
                'answers' => array_map(function(Answer $answer) use ($player) {
                    return [
                        'id' => $answer->getId(),
                        'label' => $answer->getLabel(),
                    ];
                }, $question->getAnswers()->toArray()),
            ];
        }, $questions);

        return $context;
    }

    /**
     * @Route("/", name="public")
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('play', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $player = $this->getOrCreatePlayer($name, $this->playerRepository);
            $this->addPlayerInSession($player);
        }

        return $this->render('public/index.html.twig', [
            'controller_name'  => 'PublicController',
            'form'             => $form->createView(),
            self::LAST_PLAYER  => $this->getLastPlayer(),
            self::PLAYERS_LIST => $this->getPlayerList(),
        ]);
    }

    protected function getOrCreatePlayer($name)
    {
        $player = $this->playerRepository->findOneBySlug(strtolower($name));
        if ($player) return $player;

        $player = new Player($name);
        $this->getDoctrine()->getManager()->persist($player);
        $this->getDoctrine()->getManager()->flush();

        return $player;
    }

    protected function addPlayerInSession(Player $player)
    {
        $this->session->set(self::LAST_PLAYER, $player->getName());
        $list = $this->getPlayerList();
        $this->session->set(self::PLAYERS_LIST, array_unique(array_merge($list, [$player->getName()])));
    }

    protected function getPlayerList()
    {
        return $this->session->get(self::PLAYERS_LIST, []);
    }

    protected function getLastPlayer()
    {
        return $this->session->get(self::LAST_PLAYER);
    }
}
