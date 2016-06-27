<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step06Age extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($this->request->isMethod('POST')) {
            $age = (int) $this->request->request->get('age');
            if (16 <= $age && $age <= 35) {
                $this->updateCharacterStep($age);

                return $this->nextStep();
            } else {
                $this->flashMessage('L\'âge doit être compris entre 16 et 35 ans.');
            }
        }

        return $this->renderCurrentStep([
            'age' => $this->getCharacterProperty() ?: 16,
        ]);
    }
}
