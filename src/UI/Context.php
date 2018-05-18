<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 16-05-18
 * Time: 10:44
 */

namespace App\UI;


use App\Entity\Player;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Context
 * @package App\UI
 * @Serializer\ExclusionPolicy("none")
 */
class Context
{

    /**
     * @var Player
     */
    public $player;


    /**
     * @var integer
     */
    public $points;

    /**
     * @var Question[]
     */
    public $questions = [];

    public function addQuestion(Question $question)
    {
        $this->questions[] = $question;
    }

}