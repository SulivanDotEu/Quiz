<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends \JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController
{
    /** @var array The full configuration of the entire backend */
    protected $config;
    /** @var array The full configuration of the current entity */
    protected $entity;
    /** @var Request The instance of the current Symfony request */
    protected $request;
    /** @var EntityManager The Doctrine entity manager for the current entity */
    protected $em;

    protected function createNewQuestionEntity()
    {
        $entity = new Question();
        $entity->setAnswers(new ArrayCollection([
            new Answer($entity),
            new Answer($entity),
            new Answer($entity),
            new Answer($entity),
        ]));

        return $entity;
    }

}