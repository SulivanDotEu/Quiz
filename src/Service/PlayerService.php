<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 16-05-18
 * Time: 11:05
 */

namespace App\Service;


use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PlayerService
{

    const PLAYERS_LIST = 'players_list';

    const LAST_PLAYER = 'last_player';

    /** @var SessionInterface */
    private $session;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PlayerRepository */
    private $playerRepository;

    /**
     * PlayerService constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $entityManager
     * @param PlayerRepository $playerRepository
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, PlayerRepository $playerRepository)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->playerRepository = $playerRepository;
    }

    public function getOrCreatePlayer($name)
    {
        $player = $this->playerRepository->findOneBySlug(strtolower($name));
        if ($player) return $player;

        $player = new Player($name);
        $this->entityManager->persist($player);
        $this->entityManager->getManager()->flush();

        return $player;
    }

    public function addPlayerInSession(Player $player)
    {
        $this->session->set(self::LAST_PLAYER, $player->getName());
        $list = $this->getPlayerList();
        $this->session->set(self::PLAYERS_LIST, array_unique(array_merge($list, [$player->getName()])));
    }

    public function getPlayerList()
    {
        return $this->session->get(self::PLAYERS_LIST, []);
    }

    public function getLastPlayer()
    {
        return $this->session->get(self::LAST_PLAYER);
    }

}