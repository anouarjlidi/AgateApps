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

use CorahnRin\CorahnRinBundle\Entity\Setbacks;

class Step07Setbacks extends AbstractStepAction
{
    /**
     * @var int
     */
    private $setbacksNumber = 0;

    /**
     * @var Setbacks[]
     */
    private $setbacks = [];

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /* @var Setbacks[] $setbacks */
        $this->setbacks = $this->em->getRepository('CorahnRinBundle:Setbacks')->findAll(true);

        $setbacksValue = $this->getCharacterProperty() ?: [];

        $age = $this->getCharacterProperty('06_age');

        // The user should be able to determine setbacks automatically OR manually.
        $chooseStepsManually = $this->request->query->has('manual') ?: $this->request->request->has('manual');

        // Setbacks number depends on the age, according to the books.
        $this->setbacksNumber = 0;
        if ($age > 20) {
            ++$this->setbacksNumber;
        }
        if ($age > 25) {
            ++$this->setbacksNumber;
        }
        if ($age > 30) {
            ++$this->setbacksNumber;
        }

        // Determine setbacks' specific calculation.
        if (!$this->setbacksNumber) {
            // No setback if the character is less than 21 years old.
            $setbacksValue = [];
            $this->updateCharacterStep([]);
        } elseif (!$chooseStepsManually && $this->setbacksNumber && !count($setbacksValue)) {
            // Automatic calculation (roll dices, etc.)
            $setbacksValue = $this->determineSetbacksAutomatically();
            $this->updateCharacterStep($setbacksValue);
        } elseif ($chooseStepsManually && !$this->request->isMethod('POST')) {
            // Reset setbacks only for the view when user clicked "Choose setbacks manually".
            $setbacksValue = [];
        }

        if ($this->request->isMethod('POST')) {
            if ($chooseStepsManually) {
                $setbacksValue = $this->request->request->get('setbacks_value');

                // Make sure every setback sent in POST are valid
                $anyWrongSetbackId = false;

                foreach ($setbacksValue as $id) {
                    if (!array_key_exists((int)$id, $this->setbacks)) {
                        $anyWrongSetbackId = true;
                    }
                }

                if (!$anyWrongSetbackId) {
                    $finalSetbacks = [];
                    foreach ($setbacksValue as $id) {
                        $finalSetbacks[$id] = ['id' => (int)$id, 'avoided' => false];
                    }
                    $this->updateCharacterStep($finalSetbacks);

                    return $this->nextStep();
                }

                $this->flashMessage('Veuillez entrer des revers correct(s).');
            } else {
                return $this->nextStep();
            }
        }

        return $this->renderCurrentStep([
            'age'              => $age,
            'setbacks_number'  => $this->setbacksNumber,
            'setbacks_value'   => $setbacksValue,
            'setbacks_list'    => $this->setbacks,
            'choice_available' => $chooseStepsManually,
        ]);
    }

    /**
     * @return array
     */
    private function determineSetbacksAutomatically()
    {
        $setbacksValue = [];

        // If the user does not choose to specify setbacks manually,
        // they will be determined automatically with dice throws.

        // Get the whole list in a special var so it can be modified.
        /** @var Setbacks[] $setbacksDiceList */
        $setbacksDiceList = array_values($this->setbacks);

        // A loop is made through all steps until enough setbacks have been set.
        $loopIterator = $this->setbacksNumber;
        while ($loopIterator > 0) {

            // Roll the dice. (shuffle all setbacks and get the first found)
            shuffle($setbacksDiceList);

            /** @var Setbacks $diceResult */
            $diceResult = $setbacksDiceList[0];

            // Disable unlucky setback so we don't have it twice
            unset($setbacksDiceList[0]);

            if ($diceResult->getId() === 1) {
                // Unlucky!

                // When character is unlucky, we add two setbacks instead of one

                // Add it to character's setbacks
                $setbacksValue[$diceResult->getId()] = ['id' => $diceResult->getId(), 'avoided' => false];

                // This will make another setback to be added automatically to the list.
                $loopIterator += 2;

                // We also need to remove the "lucky" setback from the list,
                // you can't be both lucky and unlucky, unfortunately ;).
                foreach ($setbacksDiceList as $k => $setback) {
                    if ($setback->getId() === 10) {
                        unset($setbacksDiceList[$k]);
                    }
                }
            } elseif ($diceResult->getId() === 10) {
                // Lucky!

                // When character is lucky, we add another setback, but mark it as "avoided".

                // Add "lucky" to list
                $setbacksValue[$diceResult->getId()] = ['id' => $diceResult->getId(), 'avoided' => false];

                // We also need to remove the "unlucky" setback from the list,
                // you can't be both lucky and unlucky, unfortunately ;).
                foreach ($setbacksDiceList as $k => $setback) {
                    if ($setback->getId() === 1) {
                        unset($setbacksDiceList[$k]);
                    }
                }

                // Now we determine which setback was avoided
                shuffle($setbacksDiceList);
                $diceResult = $setbacksDiceList[0];
                unset($setbacksDiceList[0]);

                // Then add it and mark it as avoided
                $setbacksValue[$diceResult->getId()] = ['id' => $diceResult->getId(), 'avoided' => true];
            } else {
                // If not a specific setback (lucky or unlucky),
                // We add it totally normally
                $setbacksValue[$diceResult->getId()] = ['id' => $diceResult->getId(), 'avoided' => false];
            }
            --$loopIterator;
        }

        return $setbacksValue;
    }
}
