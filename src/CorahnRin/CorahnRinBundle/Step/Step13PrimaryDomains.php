<?php

namespace CorahnRin\CorahnRinBundle\Step;

class Step13PrimaryDomains extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $allDomains    = $this->em->getRepository('CorahnRinBundle:Domains')->findAllForGenerator();
        $job           = $this->em->getRepository('CorahnRinBundle:Jobs')->findWithDomains($this->getCharacterProperty('02_job'));
        $advantages    = $this->getCharacterProperty('11_advantages');
        $mentor        = 1 === $advantages['advantages'][2]; // Mentor is advantage 2.
        $scholar       = 1 === $advantages['advantages'][23]; // Scholar is advantage 23.
        $domainsValues = $this->getCharacterProperty() ?: [];

        // Setup all values to 0 if unset.
        foreach ($allDomains as $id => $domain) {
            if (!array_key_exists($id, $domainsValues)) {
                $domainsValues[$id] = 0;
            }
        }

        // Primary domain, impossible to change.
        $domainsValues[$job->getDomainPrimary()->getId()] = 5;

        // Determine secondary domains if applicable (some jobs don't have any).
        $secondaryDomains = [];
        foreach ($job->getDomainsSecondary() as $domain) {
            $secondaryDomains[] = $domain->getId();
        }

        return $this->renderCurrentStep([
            'job'               => $job,
            'all_domains'       => $allDomains,
            'domains_values'    => $domainsValues,
            'secondary_domains' => $secondaryDomains,
        ]);
    }
}
