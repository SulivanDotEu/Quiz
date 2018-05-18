<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @Serializer\ExclusionPolicy("none")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Serializer\Type("name")
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var PlayerChoice[]
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerChoice", cascade={"ALL"}, mappedBy="player")
     */
    private $answers;

    /**
     * @var integer
     * @ORM\Column(name="points", nullable=false, options={"default":0})
     * @Serializer\Type("integer")
     */
    private $points = 0;

    private $power50;


    private $powerVote;


    private $powerFriendCall;

    public function __construct($name = null)
    {
        $this->setName($name);
        $this->setSlug(strtolower($name));
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|PlayerChoice[]
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addAnswer(PlayerChoice $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setPlayer($this);
        }

        return $this;
    }

    public function removeAnswer(PlayerChoice $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getPlayer() === $this) {
                $answer->setPlayer(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): self
    {
        $this->points = $points;

        return $this;
    }

}
