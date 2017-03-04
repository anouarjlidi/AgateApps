<?php

namespace CorahnRin\CorahnRinBundle\Step;

use Pierstoval\Bundle\CharacterManagerBundle\Action\StepAction;

abstract class AbstractStepAction extends StepAction
{
    protected static $translationDomain = 'CorahnRinBundle';

    /**
     * Renders current step view by its name.
     *
     * @param array $parameters
     *
     * @return string
     *
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
        $template = '@CorahnRin/Steps/'.$this->step->getName().'.html.twig';

        return $this->templating->renderResponse($template, $parameters);
    }
}
