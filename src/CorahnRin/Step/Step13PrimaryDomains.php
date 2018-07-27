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

use Symfony\Component\HttpFoundation\Response;
use CorahnRin\Entity\Avantages;
use CorahnRin\Entity\Domains;
use CorahnRin\Entity\Jobs;

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
     * Determines whether the character can benefit from "Scholar" advantage.
     *
     * @var bool
     */
    private $scholar;

    /**
     * @var int[]
     */
    private $secondaryDomains;

    /**
     * Keys are the following:
     * "domains":          domain_id=>domain_value
     * "military_service": domain_id|null
     * "scholar":          domain_id|null.
     *
     * @var array[]
     */
    private $domainsValues;

    /**
     * {@inheritdoc}
     */
    public function execute(): Response
    {
        $this->allDomains = $this->em->getRepository(Domains::class)->findAllSortedByName();
        $this->job = $this->em->getRepository(Jobs::class)->findWithDomains($this->getCharacterProperty('02_job'));
        $advantages = $this->getCharacterProperty('11_advantages')['advantages'];
        $this->scholar = isset($advantages[23]) && 1 === $advantages[23]; // Scholar is advantage 23.

        // This makes sure that session is not polluted with wrong data.
        $this->resetStep();

        if (!\array_key_exists('domains', $this->domainsValues)) {
            $this->domainsValues['domains'] = [];
        }

        if (!\array_key_exists('ost', $this->domainsValues)) {
            // Default "ost" value is 2: close fight.
            $this->domainsValues['ost'] = 2;
        }

        // The number of domains set for each possible value.
        $numberOf = [
            1 => 0, // Max: 2
            2 => 0, // Max: 2
            3 => 0, // Max: 1
        ];

        // Setup the number of domains set depending on their "value"
        foreach ($this->domainsValues['domains'] as $value) {
            if ($value >= 1 && $value <= 3) {
                $numberOf[$value]++;
            }
        }

        // Setup all values to 0 if unset.
        foreach ($this->allDomains as $id => $domain) {
            if (!\array_key_exists($id, $this->domainsValues['domains'])) {
                $this->domainsValues['domains'][$id] = 0;
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

        return $this->renderCurrentStep([
            'job' => $this->job,
            'all_domains' => $this->allDomains,
            'number_of' => $numberOf,
            'domains_values' => $this->domainsValues,
            'secondary_domains' => $this->secondaryDomains,
            'scholar' => $this->scholar,
            'scholar_domains_ids' => Avantages::BONUS_SCHOLAR_DOMAINS,
        ]);
    }

    /**
     * @return bool
     */
    private function managePost()
    {
        /** @var int $primaryDomainId */
        $primaryDomainId = $this->job->getDomainPrimary()->getId();

        // Primary domain, impossible to change.
        $this->domainsValues['domains'][$primaryDomainId] = 5;

        if (!$this->request->isMethod('POST')) {
            return false;
        }

        /** @var int[] $domainsValues */
        $domainsValues = $this->request->request->get('domains');

        if (null === $domainsValues) {
            return false;
        }

        foreach ($this->allDomains as $id => $domain) {
            // Allow sending partial requests with only some of the few domains.
            // Strictness is nice, but sometimes, being a bit more flexible is cool to lighten our tests :D
            if (!\array_key_exists($id, $domainsValues)) {
                $domainsValues[$id] = 0;
            }
        }

        // There should be twice 1 and 2, and once 3.
        // We don't take 5 in account because it can never be replaced.
        $numberOf1 = 0;
        $numberOf2 = 0;
        $numberOf3 = 0;

        $error = false;

        $domainsValues = \array_map(function ($v) {return (int) $v; }, $domainsValues);

        foreach ($domainsValues as $id => $domainValue) {
            if (!\array_key_exists($id, $this->allDomains)) {
                $this->flashMessage('Les domaines envoyés sont invalides.');
                unset($domainsValues[$id]);
            }

            if (!\in_array($domainValue, [0, 1, 2, 3, 5], true)) {
                $this->flashMessage('Le score d\'un domaine ne peut être que de 0, 1, 2 ou 3. Le score 5 est choisi par défaut en fonction de votre métier.');
                $error = true;
                $domainsValues[$id] = 0;
                $domainValue = 0;
            }

            if (5 === $domainValue && $id !== $primaryDomainId) {
                $this->flashMessage('Le score 5 ne peut pas être attribué à un autre domaine que celui défini par votre métier.');
                $error = true;
                $domainsValues[$id] = 0;
            }
            if (5 !== $domainValue && $id === $primaryDomainId) {
                $this->flashMessage('Le domaine principal doit avoir un score de 5, vous ne pouvez pas le changer car il est défini par votre métier.');
                $error = true;
                $domainsValues[$id] = 5;
            }

            // If value is 3, it must be for a secondary domain.
            if (3 === $domainValue) {
                if (\count($this->secondaryDomains) && !\in_array($id, $this->secondaryDomains, true)) {
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

        if (2 !== $numberOf1) {
            $this->flashMessage('La valeur 1 doit être sélectionnée deux fois.');
            $error = true;
        }
        if (2 !== $numberOf2) {
            $this->flashMessage('La valeur 2 doit être sélectionnée deux fois.');
            $error = true;
        }
        if (1 !== $numberOf3) {
            $this->flashMessage('La valeur 3 doit être sélectionnée.');
            $error = true;
        }

        $this->domainsValues['domains'] = $domainsValues;

        // These two don't throw error.
        // Scholar is safe, and ost cannot really be hacked.
        if (false === $this->checkScholar()) {
            $error = true;
        }
        if (false === $this->checkOst()) {
            $error = true;
        }

        // Reset again the primary domain, because impossible to change it.
        $this->domainsValues['domains'][$primaryDomainId] = 5;

        if (false === $error) {
            $this->updateCharacterStep($this->domainsValues);
        }

        return !$error;
    }

    /**
     * Makes sure that the "scholar" value is respected.
     *
     * @return bool false if any error occurs
     */
    private function checkScholar()
    {
        // Don't manage scholar value if don't have the advantage.
        if (false === $this->scholar) {
            $this->domainsValues['scholar'] = null;

            return true;
        }

        $id = (int) $this->request->request->get('scholar');

        $keyExists = $id
            ? \array_key_exists($id, $this->allDomains) && \in_array($id, Avantages::BONUS_SCHOLAR_DOMAINS, true)
            : null;

        if (null === $id || false === $keyExists) {
            $this->domainsValues['scholar'] = null;
            if (!$keyExists) {
                $this->flashMessage('Le domaine spécifié pour l\'avantage "Lettré" n\'est pas valide.');

                return false;
            }
        } elseif (!$id) {
            $this->flashMessage('Veuillez spécifier un domaine pour l\'avantage "Lettré".');

            return false;
        } else {
            $this->domainsValues['scholar'] = $id;
        }

        return true;
    }

    /**
     * Makes sure the "ost" domain is valid.
     *
     * @return bool false if any error occurs
     */
    private function checkOst()
    {
        $id = (int) $this->request->request->get('ost');

        $keyExists = $id ? \array_key_exists($id, $this->allDomains) : null;

        if (false === $keyExists) {
            if (0 === $id) {
                $this->domainsValues['ost'] = 2; // Default value is 2
            } else {
                $this->flashMessage('Le domaine spécifié pour le service d\'Ost n\'est pas valide.');

                return false;
            }
        } else {
            $this->domainsValues['ost'] = $id;
        }

        return true;
    }

    private function resetStep()
    {
        $sessionValue = $this->getCharacterProperty() ?: [
            'domains' => [],
            'ost' => 2,
            'scholar' => null,
        ];

        $this->domainsValues = [
            'domains' => $sessionValue['domains'],
            'ost' => $sessionValue['ost'],
            'scholar' => $sessionValue['scholar'],
        ];

        foreach ($this->allDomains as $id => $domain) {
            $this->domainsValues['domains'][$id] = 0;
        }

        // Reset again the primary domain, because impossible to change it.
        $this->domainsValues['domains'][$this->job->getDomainPrimary()->getId()] = 5;
    }
}
