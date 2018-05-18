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
use PhpParser\Node\Stmt\Label;

/**
 * Class Context
 * @package App\UI
 * @Serializer\ExclusionPolicy("none")
 */
class Answer
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var Label string
     */
    public $label;

}