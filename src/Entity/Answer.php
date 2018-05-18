<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Question
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers", cascade={"ALL"})
     */
    private $question;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $correct;

    public function __toString()
    {
        return sprintf("%s [%s]", $this->getLabel(), $this->getCorrect()?'X':' ');
    }


    /**
     * Answer constructor.
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
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

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

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
}
