<?php

namespace CorahnRin\CorahnRinBundle\Step;

class Step01People extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $peoples = $this->em->getRepository('CorahnRinBundle:Peoples')->findAll('id');

        if ($this->request->isMethod('POST')) {
            $peopleId = (int) $this->request->request->get('gen-div-choice');
            if (isset($peoples[$peopleId])) {
                $this->updateCharacterStep($peopleId);

                return $this->nextStep();
            } else {
                $this->flashMessage('Veuillez indiquer un peuple correct.');
            }
        }

        return $this->renderCurrentStep([
            'peoples'      => $peoples,
            'people_value' => $this->getCharacterProperty(),
        ]);
    }
}
