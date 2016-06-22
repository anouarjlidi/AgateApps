<?php

namespace CorahnRin\CorahnRinBundle\Action;

use Pierstoval\Bundle\CharacterManagerBundle\Action\StepAction;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractStepAction extends StepAction
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param EntityManager       $em
     * @param TwigEngine          $templating
     * @param RouterInterface     $router
     * @param TranslatorInterface $translator
     */
    public function setDefaultServices(EntityManager $em, TwigEngine $templating, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->em         = $em;
        $this->templating = $templating;
        $this->router     = $router;
        $this->translator = $translator;
    }

    /**
     * @return RedirectResponse
     */
    protected function nextStep()
    {
        return $this->goToStep($this->step->getStep() + 1);
    }

    /**
     * Redirects to a specific step and updates the session.
     *
     * @param int $stepNumber
     *
     * @return RedirectResponse
     */
    protected function goToStep($stepNumber)
    {
        foreach ($this->steps as $step) {
            if ($step->getStep() === $stepNumber) {
                $this->request->getSession()->set('step', $stepNumber);
                return new RedirectResponse($this->router->generate('pierstoval_character_generator_step', ['requestStep' => $step->getName()]));
            }
        }

        throw new \InvalidArgumentException('Invalid step: '.$stepNumber);
    }

    /**
     * @param mixed $value
     */
    protected function updateCharacterStep($value)
    {
        $character = $this->request->getSession()->get('character', []);

        $character[$this->step->getName()] = $value;

        $this->request->getSession()->set('character', $character);
    }

    /**
     * @param array $parameters
     *
     * @return string
     * @throws \Twig_Error
     */
    protected function renderCurrentStep(array $parameters = [])
    {
        // Default parameters always injected in template.
        // Not overridable, they're mandatory.
        $parameters['current_step']      = $this->step;
        $parameters['steps']             = $this->steps;
        $parameters['current_character'] = $this->getCurrentCharacter();

        // Get template name
        $template = '@CorahnRin/Steps/'.str_pad($this->step->getStep(), 2, '0', STR_PAD_LEFT).'_'.$this->step->getName().'.html.twig';

        return $this->templating->renderResponse($template, $parameters);
    }

    /**
     * Adds a new flash message.
     *
     * @param string $msg
     * @param string $type
     * @param array  $msgParams
     *
     * @return $this
     */
    public function flashMessage($msg, $type = 'error', array $msgParams = [])
    {
        $msg = $this->translator->trans($msg, $msgParams, 'error.steps');
        $this->request->getSession()->getFlashBag()->add($type, $msg);

        return $this;
    }
}
