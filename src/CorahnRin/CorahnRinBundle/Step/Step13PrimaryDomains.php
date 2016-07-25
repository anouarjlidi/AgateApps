<?php

namespace CorahnRin\CorahnRinBundle\Step;

use CorahnRin\CorahnRinBundle\Entity\Domains;
use CorahnRin\CorahnRinBundle\Entity\Jobs;

class Step13PrimaryDomains extends AbstractStepAction
{
    /**
     * @var \Generator|Domains[]
     */
    private $allDomains;

    /**
     * @var Jobs
     */
    private $job;

    /**
     * @var bool
     */
    private $mentor;

    /**
     * @var bool
     */
    private $scholar;

    /**
     * @var array[]
     */
    private $domainsValues;

    /**
     * @var int[]
     */
    private $secondaryDomains;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->allDomains    = $this->em->getRepository('CorahnRinBundle:Domains')->findAllForGenerator();
        $this->job           = $this->em->getRepository('CorahnRinBundle:Jobs')->findWithDomains($this->getCharacterProperty('02_job'));
        $advantages          = $this->getCharacterProperty('11_advantages');
        $this->mentor        = 1 === $advantages['advantages'][2]; // Mentor is advantage 2.
        $this->scholar       = 1 === $advantages['advantages'][23]; // Scholar is advantage 23.
        $this->domainsValues = $this->getCharacterProperty() ?: [];

        // Setup all values to 0 if unset.
        foreach ($this->allDomains as $id => $domain) {
            if (!array_key_exists($id, $this->domainsValues)) {
                $this->domainsValues[$id] = 0;
            }
        }

        // Determine secondary domains if applicable (some jobs don't have any).
        $this->secondaryDomains = [];
        foreach ($this->job->getDomainsSecondary() as $domain) {
            $this->secondaryDomains[] = $domain->getId();
        }

        if ($this->managePost()) {
            return $this->nextStep();
        }

        // Primary domain, impossible to change.
        $this->domainsValues[$this->job->getDomainPrimary()->getId()] = 5;

        return $this->renderCurrentStep([
            'job'               => $this->job,
            'all_domains'       => $this->allDomains,
            'domains_values'    => $this->domainsValues,
            'secondary_domains' => $this->secondaryDomains,
        ]);
    }

    /**
     * @return bool
     */
    private function managePost()
    {
        if (!$this->request->isMethod('POST')) {
            return false;
        }

        $domainsValues = $this->request->request->get('domains');
        $domainsValues = array_map('intval', $domainsValues);

        // There should be twice 1 and 2, and once 3.
        // We don't take 5 in account because it can never be replaced.
        $numberOf1 = 0;
        $numberOf2 = 0;
        $numberOf3 = 0;

        $error = false;

        foreach ($domainsValues as $id => $domainValue) {
            if (!array_key_exists($id, $this->allDomains)) {
                $this->flashMessage('Les domaines envoyés sont invalides.');
            }

            if (!in_array($domainValue, [1, 2, 3], true)) {
                $domainsValues[$id] = 0;
                $domainValue = 0;
            }

            // If value is 3, it must be for a secondary domain.
            if (3 === $domainValue) {
                if (!in_array($id, $this->secondaryDomains, true)) {
                    $this->flashMessage('La valeur 3 ne peut être donnée qu\'à l\'un des domaines de prédilection du métier choisi.');
                    $error = true;
                    $domainsValues[$id] = 0;
                }
                $numberOf3++;
                if ($numberOf3 > 1) {
                    $this->flashMessage('La valeur 3 ne peut être donnée qu\'une seule fois.');
                    $error = true;
                    $domainsValues[$id] = 0;
                }
            }

            if (2 === $domainValue) {
                $numberOf2++;
                if ($numberOf2 > 2) {
                    $this->flashMessage('La valeur 2 ne peut être donnée que deux fois.');
                    $error = true;
                    $domainsValues[$id] = 0;
                }
            }

            if (1 === $domainValue) {
                $numberOf1++;
                if ($numberOf1 > 2) {
                    $this->flashMessage('La valeur 1 ne peut être donnée que deux fois.');
                    $error = true;
                    $domainsValues[$id] = 0;
                }
            }
        }

        if ($numberOf1 !== 2) {
            $this->flashMessage('La valeur 1 doit être sélectionnée deux fois.');
            $error = true;
        }
        if ($numberOf2 !== 2) {
            $this->flashMessage('La valeur 2 doit être sélectionnée deux fois.');
            $error = true;
        }
        if ($numberOf3 !== 1) {
            $this->flashMessage('La valeur 3 doit être sélectionnée.');
            $error = true;
        }

        $this->domainsValues = $domainsValues;

        if (false === $error) {
            $this->updateCharacterStep([
                'values' => $this->domainsValues,
            ]);
        }

        return !$error;
    }
}
