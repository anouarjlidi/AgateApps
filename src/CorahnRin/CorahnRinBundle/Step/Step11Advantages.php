<?php

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Entity\Avantages;

class Step11Advantages extends AbstractStepAction
{
    /**
     * @var Avantages[][]
     */
    private $globalList;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->globalList = $this->em->getRepository('CorahnRinBundle:Avantages')->findAllDifferenciated();

        $currentStepValue = $this->getCharacterProperty();
        $advantages       = isset($currentStepValue['advantages']) ? $currentStepValue['advantages'] : [];
        $disadvantages    = isset($currentStepValue['disadvantages']) ? $currentStepValue['disadvantages'] : [];

        $experience = $this->calculateExperience($advantages, $disadvantages);

        if ($this->request->isMethod('POST')) {
            $advantages    = array_map('intval', $this->request->request->get('advantages'));
            $disadvantages = array_map('intval', $this->request->request->get('disadvantages'));

            $error = false;

            // First, validate all IDs
            foreach ($advantages as $id => $value) {
                if (!array_key_exists($id, $this->globalList['advantages'])) {
                    $error = true;
                    break;
                }
            }
            foreach ($disadvantages as $id => $value) {
                if (!array_key_exists($id, $this->globalList['disadvantages'])) {
                    $error = true;
                    break;
                }
            }

            $experience = $this->calculateExperience($advantages, $disadvantages);

            if (false === $error && $experience >= 0) {
                $this->updateCharacterStep([
                    'advantages'    => $advantages,
                    'disadvantages' => $disadvantages,
                ]);

                return $this->nextStep();
            }

            $this->flashMessage('Une erreur est survenue...');

            if (true === $error) {
                $this->flashMessage('Les avantages/désavantages soumis sont incorrects.');
            }
            if ($experience < 0) {
                $this->flashMessage('Vous n\'avez pas assez d\'expérience.');
            }
            if (false === $experience) {
                $this->flashMessage('Vos désavantages vous donnent un gain d\'expérience supérieur à 80.');
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
            } elseif ($value === 2) {
                $experience += floor($disadvantage->getXp() * 1.5);
            } elseif ($value) {
                throw new \RuntimeException('Non-handled case.');
            }
            if ($experience > 180 && $returnFalseOnError) {
                return false;
            }
        }

        unset($value);

        foreach ($advantages as $id => $value) {
            /** @var Avantages $advantage */
            $advantage = $this->globalList['advantages'][$id];
            if ($value === 1) {
                $experience -= $advantage->getXp();
            } elseif ($value === 2) {
                $experience -= floor($advantage->getXp() * 1.5);
            } elseif ($value) {
                throw new \RuntimeException('Non-handled case.');
            }
        }

        return $experience;
    }
}
