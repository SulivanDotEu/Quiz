<?php

namespace App\Controller;


use App\Repository\PlayerRepository;
use App\Repository\QuestionRepository;
use App\Service\ContextService;
use App\UI\Context;
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

    /** @var SessionInterface */
    private $session;

    /** @var QuestionRepository */
    private $questionRepository;

    /** @var $contextService */
    private $contextService;

    const PLAYERS_LIST = 'players_list';

    const LAST_PLAYER = 'last_player';

    /**
     * @param PlayerRepository $playerRepository
     * @param Session $session
     * @param QuestionRepository $questionRepository
     */
    public function __construct(PlayerRepository $playerRepository,
                                SessionInterface $session,
                                QuestionRepository $questionRepository,
                                ContextService $contextService)
    {
        $this->playerRepository = $playerRepository;
        $this->session = $session;
        $this->questionRepository = $questionRepository;
        $this->contextService = $contextService;
    }


    /**
     * @Route("/context", name="api.context.get")
     */
    public function getContext()
    {
        $context = $this->contextService->createContext();

        return new JsonResponse($context);
//        $response = new Response($content);
//        $response->headers->set("Content-Type", "application/json");
//        return $response;
    }

    /**
     * @Route("/submit", name="api.context.submit")
     */
    public function submitContext(Request $request)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);

        $content = $request->getContent();
        $context = $serializer->deserialize($content, Context::class, 'json');

        dump($context);

        return new JsonResponse($context);
    }

    protected function getLastPlayer()
    {
        return $this->session->get(self::LAST_PLAYER);
    }

}