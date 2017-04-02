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

use CorahnRin\CorahnRinBundle\Entity\Avantages;

class Step11Advantages extends AbstractStepAction
{
    /**
     * @var Avantages[][]
     */
    private $globalList;

    /**
     * @var bool
     */
    private $hasError = false;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->globalList = $this->em->getRepository('CorahnRinBundle:Avantages')->findAllDifferenciated();

        $currentStepValue = $this->getCharacterProperty();
        $advantages       = isset($currentStepValue['advantages']) ? $currentStepValue['advantages'] : [];
        $disadvantages    = isset($currentStepValue['disadvantages']) ? $currentStepValue['disadvantages'] : [];
        $setbacks         = $this->getCharacterProperty('07_setbacks');
        $isPoor           = isset($setbacks[9]) && !$setbacks[9]['avoided'];

        if ($isPoor) {
            // If character is poor, we don't allow him to have "Financial ease" advantages
            unset(
                $this->globalList['advantages'][4],
                $this->globalList['advantages'][5],
                $this->globalList['advantages'][6],
                $this->globalList['advantages'][7],
                $this->globalList['advantages'][8]
            );
        }

        $experience = $this->calculateExperience($advantages, $disadvantages);

        if ($this->request->isMethod('POST')) {
            $intval = function ($e) { return (int)$e; };
            $advantages    = array_map($intval, $this->request->request->get('advantages'));
            $disadvantages = array_map($intval, $this->request->request->get('disadvantages'));

            $numberOfAdvantages = 0;
            $numberOfUpgradedAdvantages = 0;
            $numberOfUpgradedDisadvantages = 0;
            $numberOfDisadvantages = 0;

            // First, validate all IDs
            foreach ($advantages as $id => $value) {
                if ($isPoor && in_array($id, [4, 5, 6, 7, 8], true)) {
                    $this->hasError = true;
                    $this->flashMessage('Vous ne pouvez pas choisir "Avantage financier" si votre personnage a le revers "Pauvre".');
                    break;
                }

                if (!array_key_exists($id, $this->globalList['advantages'])) {
                    $this->hasError = true;
                    $this->flashMessage('Les avantages soumis sont incorrects.');
                    break;
                }
                if (0 === $value) {
                    // Dont put zero values in session, it's useless
                    unset($advantages[$id]);
                    continue;
                }

                if (2 === $value) {
                    if ($numberOfUpgradedAdvantages + 1 > 1) {
                        $this->hasError = true;
                        $this->flashMessage('Vous ne pouvez pas améliorer plus d\'un avantage');
                    }
                    $numberOfUpgradedAdvantages++;
                }

                if ($numberOfAdvantages + 1 > 4) {
                    $this->hasError = true;
                    $this->flashMessage('Vous ne pouvez pas avoir plus de 4 avantages.');
                }
                $numberOfAdvantages++;
            }

            foreach ($disadvantages as $id => $value) {
                if (!array_key_exists($id, $this->globalList['disadvantages'])) {
                    $this->hasError = true;
                    $this->flashMessage('Les désavantages soumis sont incorrects.');
                    break;
                }
                if (0 === $value) {
                    // Dont put zero values in session, it's useless
                    unset($disadvantages[$id]);
                    continue;
                }

                if (2 === $value) {
                    if ($numberOfUpgradedDisadvantages + 1 > 1) {
                        $this->hasError = true;
                        $this->flashMessage('Vous ne pouvez pas améliorer plus d\'un désavantage');
                    }
                    $numberOfUpgradedDisadvantages++;
                }

                if ($numberOfDisadvantages + 1 > 4) {
                    $this->hasError = true;
                    $this->flashMessage('Vous ne pouvez pas avoir plus de 4 désavantages.');
                }
                $numberOfDisadvantages++;
            }

            // Validate "Ally" advantage, that cannot be combined (because it's split in multiple advantages)
            $allyIds = [1, 2, 3];
            $count = 0;
            foreach ($allyIds as $key) {
                if (isset($advantages[$key]) && $advantages[$key]) {
                    $count++;
                    if ($count > 1) {
                        $this->hasError = true;
                        $this->flashMessage('Vous ne pouvez pas combiner plusieurs avantages "Allié".');
                        break;
                    }
                }
            }

            // Validate "Financial ease" advantage, that cannot be combined (because it's split in multiple advantages)
            $financialEaseIds = [4, 5, 6, 7, 8];
            $count = 0;
            foreach ($financialEaseIds as $key) {
                if (isset($advantages[$key]) && $advantages[$key]) {
                    $count++;
                    if ($count > 1) {
                        $this->hasError = true;
                        $this->flashMessage('Vous ne pouvez pas combiner plusieurs avantages "Aisance financière".');
                        break;
                    }
                }
            }

            if (false === $this->hasError) {
                $experience = $this->calculateExperience($advantages, $disadvantages, true);
            }

            if (false === $this->hasError && $experience >= 0) {
                $this->updateCharacterStep([
                    'advantages'    => $advantages,
                    'disadvantages' => $disadvantages,
                    'remainingExp'  => $experience,
                ]);

                return $this->nextStep();
            }
        }

        return $this->renderCurrentStep([
            'experience'         => $experience,
            'advantages'         => $advantages,
            'disadvantages'      => $disadvantages,
            'advantages_list'    => $this->globalList['advantages'],
            'disadvantages_list' => $this->globalList['disadvantages'],
        ]);
    }

    /**
     * @param Avantages[] $advantages
     * @param Avantages[] $disadvantages
     * @param bool        $returnFalseOnError
     *
     * @return float|int|mixed
     */
    private function calculateExperience(array $advantages, array $disadvantages, $returnFalseOnError = false)
    {
        $experience = 100;

        foreach ($disadvantages as $id => $value) {
            /** @var Avantages $disadvantage */
            $disadvantage = $this->globalList['disadvantages'][$id];
            if ($id === 50) {
                // Specific case of the "Trauma" disadvantage
                $experience += $value * $disadvantage->getXp();
            } elseif ($value === 1) {
                $experience += $disadvantage->getXp();
            } elseif ($value === 2 && $disadvantage->getAugmentation()) {
                $experience += floor($disadvantage->getXp() * 1.5);
            } elseif ($value) {
                $this->hasError = true;
                $this->flashMessage('Une valeur incorrecte a été donnée à un désavantage.');
                return 0;
            }
            if ($experience > 180 && $returnFalseOnError) {
                $this->hasError = true;
                $this->flashMessage('Vos désavantages vous donnent un gain d\'expérience supérieur à 80.');
                return 0;
            }
        }

        unset($value);

        foreach ($advantages as $id => $value) {
            /** @var Avantages $advantage */
            $advantage = $this->globalList['advantages'][$id];
            if ($value === 1) {
                $experience -= $advantage->getXp();
            } elseif ($value === 2 && $advantage->getAugmentation()) {
                $experience -= floor($advantage->getXp() * 1.5);
            } elseif ($value) {
                $this->hasError = true;
                $this->flashMessage('Une valeur incorrecte a été donnée à un avantage.');
                return 0;
            }
        }

        if ($experience < 0) {
            $this->flashMessage('Vous n\'avez pas assez d\'expérience.');
        }

        return $experience;
    }
}
