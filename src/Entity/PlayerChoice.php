<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerChoiceRepository")
 */
class PlayerChoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="playerChoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @var Answer
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $answer;

    /**
     * @var boolean
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    private $confirmed;

    public function __toString()
    {
        return sprintf("%s? %s (%s) [%s]",
            $this->getQuestion()->getLabel(),
            $this->getAnswer()->getLabel(),
            $this->getAnswer()->getCorrect() ? "yes" : "no",
            $this->getConfirmed() ? "X" : "");
    }


    public function isCorrect()
    {
        if ($this->getConfirmed() == false) return false;
        if ($this->getAnswer() === null) return false;
        return $this->getAnswer()->getCorrect();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
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

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }


}
