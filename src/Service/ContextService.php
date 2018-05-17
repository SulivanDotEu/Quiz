<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 16-05-18
 * Time: 11:05
 */

namespace App\Service;


use App\Entity\Player;
use App\Repository\QuestionRepository;
use App\UI\Answer;
use App\UI\Context;
use App\UI\Question;

class ContextService
{
    /** @var QuestionRepository */
    protected $questionRepository;
    /** @var PlayerService */
    private $playerService;

    /**
     * ContextService constructor.
     * @param $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository, PlayerService $playerService)
    {
        $this->questionRepository = $questionRepository;
        $this->playerService = $playerService;
    }


    public function createContext()
    {
        $context = new Context();
        $context->player = $this->playerService->getLastPlayer();
        foreach ($this->getQuestion() as $question) {
            $uiQuestion = new Question();
            $uiQuestion->label = $question->getLabel();
            $uiQuestion->id = $question->getId();
            $uiQuestion->selectedAnswer = null;
            $context->addQuestion($uiQuestion);

            foreach ($question->getAnswers() as $answer) {
                $uiAnswer = new Answer();
                $uiAnswer->id = $answer->getId();
                $uiAnswer->label = $answer->getLabel();
                $uiQuestion->addAnswer($uiAnswer);
            }

        }

        return $context;
    }

    /**
     * @return \App\Entity\Question[]
     */
    public function getQuestion()
    {
        return $this->questionRepository->findBy(['active' => true]);
    }
}