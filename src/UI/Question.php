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
    const STATE_EMTPY = 'EMPTY';
    const STATE_SELECTED = 'SELECTED';
    const STATE_CONFIRMED = 'CONFIRMED';

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
     * @var string
     * @Serializer\Type("string")
     */
    public $state = self::STATE_EMTPY;

    /**
     * @var Label string
     */
    public $label;

    public function addAnswer($answer)
    {
        $this->answers[] = $answer;
    }
}