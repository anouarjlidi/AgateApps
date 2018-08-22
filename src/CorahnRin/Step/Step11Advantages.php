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

use CorahnRin\Entity\Avantages;
use CorahnRin\Entity\Setbacks;
use Symfony\Component\HttpFoundation\Response;

class Step11Advantages extends AbstractStepAction
{
    private $hasError = false;
    /**
     * @var Avantages[][]
     */
    private $globalList;

    /**
     * @var Avantages[]
     */
    private $advantages;

    /**
     * @var Avantages[]
     */
    private $disadvantages;

    /**
     * @var bool
     */
    private $isPoor;

    /**
     * @var int
     */
    private $experience;

    /**
     * @var string[]
     */
    private $indications;

    /**
     * @var Setbacks[]
     */
    private $setbacks;

    /**
     * {@inheritdoc}
     */
    public function execute(): Response
    {
        $this->globalList = $this->em->getRepository(Avantages::class)->findAllDifferenciated();

        $currentStepValue = $this->getCharacterProperty();
        $this->advantages = $currentStepValue['advantages'] ?? [];
        $this->disadvantages = $currentStepValue['disadvantages'] ?? [];
        $characterSetbacks = $this->getCharacterProperty('07_setbacks');
        $nonAvoidedSetbacks = [];
        foreach  ($characterSetbacks as $id => $values) {
            if ($values['avoided']) {
                continue;
            }
            $nonAvoidedSetbacks[] = $id;
        }
        $this->setbacks = $this->em->getRepository(Setbacks::class)->findWithDisabledAdvantages($nonAvoidedSetbacks);

        dump($this->setbacks, $this->globalList);
        // Disable advantages that must not be chosen based on setbacks
        foreach ($this->setbacks as $setback) {
            if (\count($disabledDisadvantages = $setback->getDisabledAdvantages()) > 0) {
                dump('disabling ', $disabledDisadvantages);
                foreach ($disabledDisadvantages as $advantage) {
                    unset(
                        $this->globalList['advantages'][$advantage->getId()],
                        $this->globalList['disadvantages'][$advantage->getId()]
                    );
                }
            }
        }

        $this->indications = \array_filter($currentStepValue['advantages_indications'] ?? []);

        $this->experience = $this->calculateExperience();

        if ($response = $this->handlePost()) {
            return $response;
        }

        return $this->renderCurrentStep([
            'experience' => $this->experience,
            'indication_type_single_choice' => Avantages::INDICATION_TYPE_SINGLE_CHOICE,
            'indication_type_single_value' => Avantages::INDICATION_TYPE_SINGLE_VALUE,
            'character_indications' => $this->indications,
            'advantages' => $this->advantages,
            'disadvantages' => $this->disadvantages,
            'advantages_list' => $this->globalList['advantages'],
            'disadvantages_list' => $this->globalList['disadvantages'],
        ], 'corahn_rin/Steps/11_advantages.html.twig');
    }

    /**
     * @param Avantages[] $advantages
     * @param Avantages[] $disadvantages
     * @param bool        $returnFalseOnError
     *
     * @return float|int|mixed
     */
    private function calculateExperience($returnFalseOnError = false)
    {
        $advantages = $this->advantages;
        $disadvantages = $this->disadvantages;
        $this->experience = 100;

        foreach ($disadvantages as $id => $value) {
            /** @var Avantages $disadvantage */
            $disadvantage = $this->globalList['disadvantages'][$id];
            if (50 === $id) {
                // Specific case of the "Trauma" disadvantage
                $this->experience += $value * $disadvantage->getXp();
            } elseif (1 === $value) {
                $this->experience += $disadvantage->getXp();
            } elseif (2 === $value && $disadvantage->getAugmentation()) {
                $this->experience += \floor($disadvantage->getXp() * 1.5);
            } elseif ($value) {
                $this->hasError = true;
                $this->flashMessage('Une valeur incorrecte a été donnée à un désavantage.');

                return 0;
            }
            if ($this->experience > 180 && $returnFalseOnError) {
                $this->hasError = true;
                $this->flashMessage('Vos désavantages vous donnent un gain d\'expérience supérieur à 80.');

                return 0;
            }
        }

        unset($value);

        foreach ($advantages as $id => $value) {
            /** @var Avantages $advantage */
            $advantage = $this->globalList['advantages'][$id];
            if (1 === $value) {
                $this->experience -= $advantage->getXp();
            } elseif (2 === $value && $advantage->getAugmentation()) {
                $this->experience -= \floor($advantage->getXp() * 1.5);
            } elseif ($value) {
                $this->hasError = true;
                $this->flashMessage('Une valeur incorrecte a été donnée à un avantage.');

                return 0;
            }
        }

        if ($this->experience < 0) {
            $this->flashMessage('Vous n\'avez pas assez d\'expérience.');
        }

        return $this->experience;
    }

    private function handlePost(): ?Response
    {
        if (!$this->request->isMethod('POST')) {
            return null;
        }

        $intval = function ($e) { return (int) $e; };
        $this->indications = \array_filter($this->request->request->get('advantages_indications'));
        $advantages = \array_map($intval, $this->request->request->get('advantages'));
        $disadvantages = \array_map($intval, $this->request->request->get('disadvantages'));

        $numberOfAdvantages = 0;
        $numberOfUpgradedAdvantages = 0;
        $numberOfUpgradedDisadvantages = 0;
        $numberOfDisadvantages = 0;

        // First, validate all IDs
        foreach ($advantages as $id => $value) {

            if ($this->isPoor && \in_array($id, [4, 5, 6, 7, 8], true)) {
                $this->hasError = true;
                $this->flashMessage('Vous ne pouvez pas choisir "Avantage financier" si votre personnage a le revers "Pauvre".');
                break;
            }

            if (!\array_key_exists($id, $this->globalList['advantages'])) {
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

            $advantage = $this->globalList['advantages'][$id];

            if (null === $advantage) {
                $this->hasError = true;
                $this->flashMessage('Les avantages soumis sont incorrects.');
                break;
            }

            if (0 !== $value && $advantage->getRequiresIndication()) {
                $indication = trim($this->indications[$id] ?? '');
                if (!$indication) {
                    $this->hasError = true;
                    $this->flashMessage('L\'avantage "%advtg%" nécessite une indication supplémentaire.', 'error', ['%advtg%' => $advantage->getName()]);
                    break;
                }
                if ($advantage->getIndicationType() === Avantages::INDICATION_TYPE_SINGLE_CHOICE) {
                    $choices = $advantage->getBonusesFor();
                    if (!\in_array($indication, $choices, true)) {
                        $this->hasError = true;
                        $this->flashMessage('L\'indication pour l\'avantage "%advtg%" n\'est pas correcte, veuillez vérifier.', 'error', ['%advtg%' => $advantage->getName()]);
                        break;
                    }
                }
            }

            if ($numberOfAdvantages + 1 > 4) {
                $this->hasError = true;
                $this->flashMessage('Vous ne pouvez pas avoir plus de 4 avantages.');
            }
            $numberOfAdvantages++;
        }

        foreach ($disadvantages as $id => $value) {
            if (!\array_key_exists($id, $this->globalList['disadvantages'])) {
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

            $disadvantage = $this->globalList['disadvantages'][$id];

            if (null === $disadvantage) {
                $this->hasError = true;
                $this->flashMessage('Les désavantages soumis sont incorrects.');
                break;
            }

            if (0 !== $value && $disadvantage->getRequiresIndication()) {
                $indication = trim($this->indications[$id] ?? '');
                if (!$indication) {
                    $this->hasError = true;
                    $this->flashMessage('Le désavantage "%advtg%" nécessite une indication supplémentaire.', 'error', ['%advtg%' => $disadvantage->getName()]);
                    break;
                }
                if ($disadvantage->getIndicationType() === Avantages::INDICATION_TYPE_SINGLE_CHOICE) {
                    $choices = $disadvantage->getBonusesFor();
                    if (!\in_array($indication, $choices, true)) {
                        $this->hasError = true;
                        $this->flashMessage('L\'indication pour le désavantage "%advtg%" n\'est pas correcte, veuillez vérifier.', 'error', ['%advtg%' => $disadvantage->getName()]);
                        break;
                    }
                }
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
            if (!empty($advantages[$key])) {
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
            if (!empty($advantages[$key])) {
                $count++;
                if ($count > 1) {
                    $this->hasError = true;
                    $this->flashMessage('Vous ne pouvez pas combiner plusieurs avantages "Aisance financière".');
                    break;
                }
            }
        }

        if (false === $this->hasError) {
            $this->experience = $this->calculateExperience(true);
        }

        if (false === $this->hasError && $this->experience >= 0) {
            $this->updateCharacterStep([
                'advantages' => $advantages,
                'disadvantages' => $disadvantages,
                'advantages_indications' => $this->indications,
                'remainingExp' => $this->experience,
            ]);

            return $this->nextStep();
        }

        return null;
    }
}
