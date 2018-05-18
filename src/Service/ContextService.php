<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 16-05-18
 * Time: 11:05
 */

namespace App\Service;


use App\Entity\Player;
use App\Entity\PlayerChoice;
use App\Repository\PlayerChoiceRepository;
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
    public function __construct(QuestionRepository $questionRepository, PlayerService $playerService, PlayerChoiceRepository $playerChoiceRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->playerChoiceRepository = $playerChoiceRepository;
        $this->playerService = $playerService;
    }


    public function createContext(Player $player = null)
    {
        $answers = $this->getAnswers($player);

        $context = new Context();
        $context->player = $this->playerService->getLastPlayer();
        $context->points = $player->getPoints();
        foreach ($this->getQuestion() as $question) {
            $uiQuestion = new Question();
            $uiQuestion->label = $question->getLabel();
            $uiQuestion->id = $question->getId();
            $uiQuestion->selectedAnswer = null;
            $context->addQuestion($uiQuestion);

            if (isset($answers[$question->getId()])) {
                /** @var PlayerChoice $choice */
                $choice = $answers[$question->getId()];
                $uiQuestion->state = $choice->getConfirmed() ? Question::STATE_CONFIRMED : Question::STATE_SELECTED;
                $answer = $choice->getAnswer();

                if ($answer) {
                    $a = new Answer();
                    $a->id = $answer->getId();
                    $a->label = $answer->getLabel();
                    $uiQuestion->selectedAnswer = $a;
                }
            }


            foreach ($question->getAnswers() as $answer) {
                $uiAnswer = new Answer();
                $uiAnswer->id = $answer->getId();
                $uiAnswer->label = $answer->getLabel();
                $uiQuestion->addAnswer($uiAnswer);
            }

        }

        return $context;
    }

    public function getAnswers(Player $player)
    {
        $answers = $this->playerChoiceRepository->findBy(['player' => $player]);
        $array = [];
        foreach ($answers as $answer) {
            $array[$answer->getQuestion()->getId()] = $answer;
        }
        return $array;
    }

    public function getQuestions()
    {
        $questions = $this->questionRepository->findBy(['active' => true]);
        $array = [];
        foreach ($questions as $question) {
            $array[$question->getId()] = $question;
        }
        return $array;
    }

    /**
     * @return \App\Entity\Question[]
     */
    public function getQuestion()
    {
        return $this->questionRepository->findBy(['active' => true]);
    }
}