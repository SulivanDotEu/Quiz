<?php
namespace App\UI;


use App\Entity\Player;
use JMS\Serializer\Annotation as Serializer;
use PhpParser\Node\Stmt\Label;

/**
 * Class Context
 * @package App\UI
 * @Serializer\ExclusionPolicy("none")
 */
class Question
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var Answer[]
     * @Serializer\Type("array<App\UI\Answer>")
     */
    public $answers = array();

    /**
     * @var Answer
     * @Serializer\Type("App\UI\Answer")
     */
    public $selectedAnswer;

    /**
     * @var Label string
     */
    public $label;

    public function addAnswer($answer)
    {
        $this->answers[] = $answer;
    }
}