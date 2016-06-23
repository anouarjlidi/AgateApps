<?php

namespace CorahnRin\CorahnRinBundle\Action;

use CorahnRin\CorahnRinBundle\Data\Orientation;

class Step10Orientation extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $orientation = $this->getCharacterProperty();

        // Ways keys are automatically set to ways ids. It's safe.
        $ways = $this->getCharacterProperty('08_ways');

        // These data are static and are not related to anything else in the app.
        $orientations = Orientation::getData();

        $com = $ways[1];
        $cre = $ways[2];
        $rai = $ways[4];
        $ide = $ways[5];

        $conscience = $rai + $ide;
        $instinct   = $com + $cre;

        $canBeChanged = $conscience === $instinct;

        if ($conscience > $instinct) {
            $orientation = Orientation::RATIONAL;
        } elseif ($instinct > $conscience) {
            $orientation = Orientation::INSTINCTIVE;
        }

        if ($this->request->isMethod('POST')) {
            if ($canBeChanged) {
                $orientation = $this->request->request->get('gen-div-choice');
            }

            $orientation_exists = array_key_exists($orientation, $orientations);

            if ($orientation_exists) {
                $this->updateCharacterStep($orientation);

                return $this->nextStep();
            } else {
                $this->flashMessage('L\'orientation de la personnalité est incorrecte, veuillez vérifier.', null, 'error');
            }
        }

        return $this->renderCurrentStep([
            'can_be_changed'    => $canBeChanged,
            'orientation_value' => $orientation,
            'orientations'      => $orientations,
        ]);
    }
}
