<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerQuestionRepository")
 */
class PlayerQuestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     */
    private $player;

    /**
     * @var Question
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     */
    private $question;

    /**
     * @var Answer
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer")
     */
    private $choice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
