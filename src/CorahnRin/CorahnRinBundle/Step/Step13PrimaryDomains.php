<?php

namespace CorahnRin\CorahnRinBundle\Step;

class Step13PrimaryDomains extends AbstractStepAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $allDomains = $this->em->getRepository('CorahnRinBundle:Domains')->findAllForGenerator();
        $job        = $this->em->find('CorahnRinBundle:Jobs', $this->getCharacterProperty('02_job'));
        $advantages = $this->getCharacterProperty('11_advantages');

        // Mentor is advantage 2.
        $mentor = 1 === $advantages['advantages'][2];

        // Scholar is advantage 23.
        $scholar = 1 === $advantages['advantages'][23];

        $domainsValues = $this->getCharacterProperty();

        return $this->renderCurrentStep([
            'all_domains' => $allDomains,
            'domains_values' => $domainsValues,
        ]);
    }
}
