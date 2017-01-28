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

        return $this->renderCurrentStep([
            'domains_values' => $this->domainsCalculatedValues,
            'bonus_max' => $this->bonus,
            'bonus_value' => $this->getCharacterProperty(),
        ]);
    }

    private function checkDomainIdForBonus($domainId)
    {
        if ($this->domainsCalculatedValues[$domainId] === 5) {
            $this->bonus++;
        } else {
            $this->domainsCalculatedValues[$domainId]++;
        }
    }
}
