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
