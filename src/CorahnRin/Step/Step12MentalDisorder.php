<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Step;

use Symfony\Component\HttpFoundation\Response;

class Step12MentalDisorder extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute(): Response
    {
        $disorderValue = $this->getCharacterProperty();

        /** @var int[] $ways */
        $ways = $this->getCharacterProperty('08_ways');

        // They MUST be indexed by ids by the repository.
        $disorders = $this->em->getRepository(\CorahnRin\Entity\Disorders::class)->findWithWays();

        $definedDisorders = [];

        // Fetch "minor" and "major" ways to check for compatible disorders.
        $majorWays = $minorWays = [];
        foreach ($ways as $id => $value) {
            if ($value < 3) {
                $minorWays[$id] = 1;
            } elseif ($value > 3) {
                $majorWays[$id] = 1;
            }
        }

        // Test all disorders with current ways major and minor values.
        foreach ($disorders as $disorder) {
            $disorderWays = $disorder->getWays();
            foreach ($disorderWays as $disorderWay) {
                if (
                    ($disorderWay->isMajor() && array_key_exists($disorderWay->getWay()->getId(), $majorWays))
                    || (!$disorderWay->isMajor() && array_key_exists($disorderWay->getWay()->getId(), $minorWays))
                ) {
                    $definedDisorders[$disorder->getId()] = $disorder;
                }
            }
        }

        // Validate form.
        if ($this->request->isMethod('POST')) {
            $disorderValue = (int) $this->request->request->get('gen-div-choice');

            // Success!
            if (array_key_exists($disorderValue, $disorders)) {
                $this->updateCharacterStep((int) $disorderValue);

                return $this->nextStep();
            }

            if (0 === $disorderValue) {
                $this->flashMessage('Veuillez choisir un désordre mental.');
            } else {
                $this->flashMessage('Le désordre mental choisi n\'existe pas.');
            }
        }

        return $this->renderCurrentStep([
            'disorder_value' => $disorderValue,
            'disorders'      => $definedDisorders,
        ]);
    }
}
