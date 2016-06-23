<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step09Traits extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $ways = $this->getCharacterProperty('08_ways');

        $traitsList = $this->em->getRepository('CorahnRinBundle:Traits')->findAllDependingOnWays($ways);

        $traits = $this->getCharacterProperty();

        $quality = isset($traits['quality']) ? $traits['quality'] : null;
        $flaw    = isset($traits['flaw']) ? $traits['flaw'] : null;

        if ($this->request->isMethod('POST')) {
            $quality = (int) $this->request->request->get('quality');
            $flaw    = (int) $this->request->request->get('flaw');

            $quality_exists = array_key_exists($quality, $traitsList['qualities']);
            $flaw_exists    = array_key_exists($flaw, $traitsList['flaws']);

            if ($quality_exists && $flaw_exists) {
                $this->updateCharacterStep([
                    'quality' => $quality,
                    'flaw'    => $flaw,
                ]);

                return $this->nextStep();
            } else {
                $this->flashMessage('Les traits de caractère choisis sont incorrects.', 'error.steps');
            }
        }

        return $this->renderCurrentStep([
            'quality'     => $quality,
            'flaw'        => $flaw,
            'traits_list' => $traitsList,
        ]);

    }
}
