<?php

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Entity\Domains;

class Step14UseDomainBonuses extends AbstractStepAction
{
    /**
     * @var \Generator|Domains[]
     */
    private $allDomains;

    /**
     * Here we'll store all final values for all domains.
     * As some advantages/properties can give more points to domains,
     *  they might be different than the values set at step 13_primary_domains.
     *
     * @var array
     */
    private $domainsCalculatedValues = [];

    /**
     * Bonuses will be calculated based on primary domains,
     *  and all other advantages/properties of the character can
     *  add bonuses depending on their values.
     *
     * @var int
     */
    private $bonus = 0;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->allDomains = $this->em->getRepository('CorahnRinBundle:Domains')->findAllForGenerator();

        $geoEnvironment = $this->em->find('CorahnRinBundle:GeoEnvironments', $this->getCharacterProperty('04_geo'));

        $socialClassValues = $this->getCharacterProperty('05_social_class');
        /** @var int[] $socialClassDomains */
        $socialClassDomains = $socialClassValues['domains'];

        /** @var int[] $domainsBonuses */
        $domainsBonuses = $this->getCharacterProperty();

        if (null === $domainsBonuses) {
            $domainsBonuses = $this->resetBonuses();
        }

        /** @var array[] $primaryDomains */
        $primaryDomains = $this->getCharacterProperty('13_primary_domains');

        // First, let's get the base values set at previous step.
        foreach ($primaryDomains['domains'] as $id => $value) {
            $this->domainsCalculatedValues[$id] = $value;
        }

        // Next, process social class domains values or bonuses.
        foreach ($socialClassDomains as $domainId) {
            $this->checkDomainIdForBonus($domainId);
        }

        // Process bonuses for:
        // GeoEnvironment
        // Ost service
        // Scholar advantage (if set)
        $this->checkDomainIdForBonus($geoEnvironment->getId());
        $this->checkDomainIdForBonus($primaryDomains['ost']);
        if ($primaryDomains['scholar']) {
            $this->checkDomainIdForBonus($primaryDomains['scholar']);
        }

        // If "mentor ally" is selected, then the character has a bonus to one domain.
        // Thanks to him! :D
        $advantages = $this->getCharacterProperty('11_advantages');
        $mentor = $advantages['advantages'][2];
        $this->bonus += $mentor; // $mentor can be 0 or 1 only so no problem with this operation.

        /** @var int $age */
        $age = $this->getCharacterProperty('06_age');
        if ($age > 20) {
            ++$this->bonus;
        }
        if ($age > 25) {
            ++$this->bonus;
        }
        if ($age > 30) {
            ++$this->bonus;
        }

        $bonusValue = $this->bonus;

        // Manage form submit
        if ($this->request->isMethod('POST')) {
            /** @var int[] $postedValues */
            $postedValues = $this->request->request->get('domains_bonuses');

            $remainingPoints = $bonusValue;
            $spent = 0;

            $error = false;

            foreach (array_keys($domainsBonuses) as $id) {
                $value = isset($postedValues[$id]) ? $postedValues[$id] : null;
                if (!array_key_exists($id, $postedValues) || !in_array($postedValues[$id], ['0', '1'], true)) {
                    // If there is any error, we do nothing.
                    $this->flashMessage('errors.incorrect_values');
                    $error = true;
                    break;
                }
                if ('1' === $value) {
                    $remainingPoints--;
                    $spent++;
                }

                $domainsBonuses[$id] = (int) $value;
            }

            if ($remainingPoints < 0) {
                $this->flashMessage('domains_bonuses.errors.too_many_points', null, ['%base%' => $this->bonus, '%spent%' => $spent]);
                $error = true;
            }

            if (false === $error) {
                if ($remainingPoints > 2) {
                    $this->flashMessage('domains_bonuses.errors.more_than_two', null, ['%count%' => $remainingPoints]);
                } elseif ($remainingPoints >= 0) {
                    $finalArray = $domainsBonuses;
                    $finalArray['remaining'] = $remainingPoints;
                    $this->updateCharacterStep($finalArray);

                    return $this->nextStep();
                }
            } else {
                $domainsBonuses = $this->resetBonuses();
                $this->updateCharacterStep(null);
                $bonusValue = $this->bonus;
            }
        }

        return $this->renderCurrentStep([
            'all_domains' => $this->allDomains,
            'domains_values' => $this->domainsCalculatedValues,
            'domains_bonuses' => $domainsBonuses,
            'bonus_max' => $this->bonus,
            'bonus_value' => $bonusValue,
        ]);
    }

    /**
     * @param int $domainId
     */
    private function checkDomainIdForBonus($domainId)
    {
        if ($this->domainsCalculatedValues[$domainId] === 5) {
            $this->bonus++;
        } else {
            $this->domainsCalculatedValues[$domainId]++;
        }
    }

    /**
     * @return int[]
     */
    private function resetBonuses()
    {
        $domainsBonuses = [];

        foreach ($this->allDomains as $domain) {
            $domainsBonuses[$domain->getId()] = 0;
        }

        return $domainsBonuses;
    }
}
