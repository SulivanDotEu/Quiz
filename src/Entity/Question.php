<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=500)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", fetch="EAGER", cascade={"ALL"})
     */
    private $answers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $point;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerChoice", mappedBy="question", orphanRemoval=true)
     */
    private $playerChoices;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->playerChoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers($answers): self
    {
        $this->answers = $answers;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlayerChoice[]
     */
    public function getPlayerChoices(): Collection
    {
        return $this->playerChoices;
    }

    public function addPlayerChoice(PlayerChoice $playerChoice): self
    {
        if (!$this->playerChoices->contains($playerChoice)) {
            $this->playerChoices[] = $playerChoice;
            $playerChoice->setQuestion($this);
        }

        return $this;
    }

    public function removePlayerChoice(PlayerChoice $playerChoice): self
    {
        if ($this->playerChoices->contains($playerChoice)) {
            $this->playerChoices->removeElement($playerChoice);
            // set the owning side to null (unless already changed)
            if ($playerChoice->getQuestion() === $this) {
                $playerChoice->setQuestion(null);
            }
        }

        return $this;
    }

    public function getAnswerById($id)
    {
        foreach ($this->getAnswers() as $answer) {
            if($answer->getId() == $id) return $answer;
        }
        return null;
    }
}
