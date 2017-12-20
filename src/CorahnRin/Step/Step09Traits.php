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

class Step09Traits extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute(): Response
    {
        $ways = $this->getCharacterProperty('08_ways');

        $traitsList = $this->em->getRepository(\CorahnRin\Entity\Traits::class)->findAllDependingOnWays($ways);

        $traits = $this->getCharacterProperty();

        $quality = $traits['quality'] ?? null;
        $flaw    = $traits['flaw'] ?? null;

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
            }
            $this->flashMessage('Les traits de caractère choisis sont incorrects.');
        }

        return $this->renderCurrentStep([
            'quality'     => $quality,
            'flaw'        => $flaw,
            'traits_list' => $traitsList,
        ]);
    }
}
