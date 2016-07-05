<?php

namespace CorahnRin\CorahnRinBundle\Action;

use CorahnRin\CorahnRinBundle\Entity\Avantages;

class Step11Advantages extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $globalList = $this->em->getRepository('CorahnRinBundle:Avantages')->findAllDifferenciated();

        $experience = 100;

        $currentStepValue = $this->getCharacterProperty();
        $advantages       = isset($currentStepValue['advantages']) ? $currentStepValue['advantages'] : [];
        $disadvantages    = isset($currentStepValue['disadvantages']) ? $currentStepValue['disadvantages'] : [];

        foreach ($advantages as $id => $value) {
            /** @var Avantages $advantage */
            $advantage = $globalList['advantages'][$id];
            if ($value === 1) {
                $experience -= $advantage->getXp();
            } elseif ($value === 2) {
                $experience -= (int) ($advantage->getXp() * 1.5);
            } else {
                throw new \RuntimeException('Non-handled case.');
            }
        }
        foreach ($disadvantages as $id => $value) {
            /** @var Avantages $disadvantage */
            $disadvantage = $globalList['advantages'][$id];
            if ($id === 50) {
                // Specific case of the "Trauma" disadvantage
                $experience += $value * $disadvantage->getXp();
            } elseif ($value === 1) {
                    $experience += $disadvantage->getXp();
            } elseif ($value === 2) {
                $experience += (int) ($disadvantage->getXp() * 1.5);
            } else {
                throw new \RuntimeException('Non-handled case.');
            }
        }

        if ($this->request->isMethod('POST')) {
            $selectedAdvantages    = $this->request->request->get('advantages');
            $selectedDisadvantages = $this->request->request->get('disadvantages');

            $error = false;

            foreach ($selectedAdvantages as $id => $value) {
                if (
                    !isset($advantages[$id])
                    || !is_numeric($id)
                    || !is_numeric($value)
                    || $advantages[$id]->getAugmentation() < $value
                ) {
                    $error = true;
                    break;
                }
            }

            if (false === $error) {
                $this->updateCharacterStep([
                    'advantages'    => $selectedAdvantages,
                    'disadvantages' => $selectedDisadvantages,
                ]);

                return $this->nextStep();
            } else {
                $this->flashMessage('Une erreur est survenue dans la sélection d\'avantages ou de désavantages.', 'error.steps');
            }
        }

        return $this->renderCurrentStep([
            'experience'         => $experience,
            'advantages'         => $advantages,
            'disadvantages'      => $disadvantages,
            'advantages_list'    => $globalList['advantages'],
            'disadvantages_list' => $globalList['disadvantages'],
        ]);
    }
}
