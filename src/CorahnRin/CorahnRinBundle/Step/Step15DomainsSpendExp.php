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

        $step13Domains = $this->getCharacterProperty('13_primary_domains');
        $socialClassValues = $this->getCharacterProperty('05_social_class')['domains'];
        $domainBonuses = $this->getCharacterProperty('14_use_domain_bonuses');
        $geoEnvironment = $this->em->find('CorahnRinBundle:GeoEnvironments', $this->getCharacterProperty('04_geo'));

        $domainsBaseValues = $this->domainsCalculator->calculateFromGeneratorData(
            $this->allDomains,
            $socialClassValues,
            $step13Domains['ost'],
            $step13Domains['scholar'] ?: null,
            $geoEnvironment,
            $step13Domains['domains'],
            $domainBonuses
        );

        /** @var int[] $currentDomainsSpentWithExp */
        $this->domainsSpentWithExp = $this->getCharacterProperty();

        if (null === $this->domainsSpentWithExp) {
            $domainsSpentWithExp = $this->resetDomains();
        }

        return $this->renderCurrentStep([
            'domains_base_values' => $domainsBaseValues,
            'domains_spent_with_exp' => $this->domainsSpentWithExp,
        ]);
    }

    private function resetDomains()
    {
        foreach ($this->allDomains as $id => $value) {
            $this->domainsSpentWithExp[$id] = 0;
        }
    }

}
