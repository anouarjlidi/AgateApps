<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Step;

use Symfony\Component\HttpFoundation\Response;
use CorahnRin\CorahnRinBundle\Data\Orientation;

class Step10Orientation extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute(): Response
    {
        $orientation = $this->getCharacterProperty();

        // Ways keys are automatically set to ways ids. It's safe.
        $ways = $this->getCharacterProperty('08_ways');

        // These data are static and are not related to anything else in the app.
        $orientations = Orientation::getData();

        $instinct   = $ways[1] + $ways[2]; // Combativeness + Creativity
        $conscience = $ways[4] + $ways[5]; // Reason + Conviction

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
            }

            $this->flashMessage('L\'orientation de la personnalité est incorrecte, veuillez vérifier.', 'error');
        }

        return $this->renderCurrentStep([
            'can_be_changed'    => $canBeChanged,
            'orientation_value' => $orientation,
            'orientations'      => $orientations,
        ]);
    }
}
