<?php

namespace CorahnRin\CorahnRinBundle\Action;

class Step12MentalDisorder extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $disorderValue = $this->getCharacterProperty();

        $ways = $this->getCharacterProperty('08_ways');

        // They MUST be indexed by ids by the repository.
        $disorders = $this->em->getRepository('CorahnRinBundle:Disorders')->findWithWays();

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
            $disorderValue = $this->request->request->get('gen-div-choice');

            // Success!
            if (array_key_exists($disorderValue, $disorders)) {
                $this->updateCharacterStep((int) $disorderValue);

                return $this->nextStep();
            }

            $this->flashMessage('Le désordre mental choisi n\'existe pas.');
        }

        return $this->renderCurrentStep([
            'disorder_value' => $disorderValue,
            'disorders'      => $definedDisorders,
        ]);
    }
}
