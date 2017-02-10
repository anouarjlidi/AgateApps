<?php

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Entity\Domains;
use CorahnRin\CorahnRinBundle\GeneratorTools\DomainsCalculator;

class Step15DomainsSpendExp extends AbstractStepAction
{
    /**
     * @var \Generator|Domains[]
     */
    private $allDomains;

    /**
     * Basic principle: each domain point costs 10XP.
     * Exp is retrieved from advantages/disadvantages calculations.
     *
     * @var int
     */
    private $exp = 0;

    /**
     * @var DomainsCalculator
     */
    private $domainsCalculator;

    /**
     * @var int[]
     */
    private $domainsSpentWithExp;

    /**
     * @var int
     */
    private $expRemainingFromAdvantages;

    public function __construct(DomainsCalculator $domainsCalculator)
    {
        $this->domainsCalculator = $domainsCalculator;
    }

    /**
     * {@inheritdoc}
     *
     * @internal int[] $socialClassValues
     */
    public function execute()
    {
        $this->allDomains = $this->em->getRepository('CorahnRinBundle:Domains')->findAllForGenerator();

        $primaryDomains = $this->getCharacterProperty('13_primary_domains');
        $socialClassValues = $this->getCharacterProperty('05_social_class')['domains'];
        $domainBonuses = $this->getCharacterProperty('14_use_domain_bonuses');
        $geoEnvironment = $this->em->find('CorahnRinBundle:GeoEnvironments', $this->getCharacterProperty('04_geo'));

        $domainsBaseValues = $this->domainsCalculator->calculateFromGeneratorData(
            $this->allDomains,
            $socialClassValues,
            $primaryDomains['ost'],
            $primaryDomains['scholar'] ?: null,
            $geoEnvironment,
            $primaryDomains['domains'],
            $domainBonuses
        );

        $this->expRemainingFromAdvantages = $this->getCharacterProperty('11_advantages')['remainingExp'];

        /** @var int[] $currentDomainsSpentWithExp */
        $this->domainsSpentWithExp = $this->getCharacterProperty();

        if (null === $this->domainsSpentWithExp) {
            $this->resetDomains();
        }

        return $this->renderCurrentStep([
            'all_domains' => $this->allDomains,
            'domains_base_values' => $domainsBaseValues,
            'domains_spent_with_exp' => $this->domainsSpentWithExp['domains'],
            'exp_max' => $this->expRemainingFromAdvantages,
            'exp_value' => $this->domainsSpentWithExp['remainingExp'],
        ]);
    }

    private function resetDomains()
    {
        $this->domainsSpentWithExp = [
            'domains' => [],
            'remainingExp' => $this->expRemainingFromAdvantages,
        ];

        foreach ($this->allDomains as $id => $value) {
            $this->domainsSpentWithExp['domains'][$id] = 0;
        }
    }

}
