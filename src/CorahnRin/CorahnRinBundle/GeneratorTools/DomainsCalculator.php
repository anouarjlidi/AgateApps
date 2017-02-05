<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\GeneratorTools;

use CorahnRin\CorahnRinBundle\Entity\Domains;
use CorahnRin\CorahnRinBundle\Entity\GeoEnvironments;

final class DomainsCalculator
{
    /**
     * @var int[]
     */
    private $finalCalculatedDomains = [];

    /**
     * @var int
     */
    private $bonus = 0;

    /**
     * If $domainsBonuses IS NOT provided, then it will return calculated domains values with an array of this type:
     * [ 'bonus'=>X, 'domains'=>[...] ]
     * Mostly used for step 14.
     *
     * If $domainsBonuses IS provided, then it will a
     *
     * @param Domains[] $allDomains
     * @param array $socialClasses
     * @param int $ost
     * @param int $scholar
     * @param GeoEnvironments $geoEnv
     * @param array $primaryDomains
     * @param array $domainsBonuses
     *
     * @return int[]
     */
    public function calculateFromGeneratorData($allDomains, array $socialClasses, $ost, $scholar = null, GeoEnvironments $geoEnv, array $primaryDomains, array $domainsBonuses = null)
    {
        $this->bonus = 0;
        $this->finalCalculatedDomains = [];

        /**
         * Step 13 primary domains and step 14 bonuses
         */
        foreach ($allDomains as $id => $domain) {

            // First, validate arguments.
            if (!($domain instanceof Domains) || $domain->getId() !== $id) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid %s argument sent. It must be an array of %s instances, and the array key must correspond to the "%s" property.',
                    '$allDomains', Domains::class, 'id'
                ));
            }

            if (!isset($primaryDomains[$id])) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid %s argument sent. It must be an array of %s, and the array key must correspond to the "%s" property.',
                    '$primaryDomains', 'integers', 'domain id'
                ));
            }

            /**
             * Step 13 primary domains
             */
            $this->finalCalculatedDomains[$id] = $primaryDomains[$id];

            /**
             * Step 14 domain bonuses (if set)
             */
            if (null !== $domainsBonuses) {
                if (!array_key_exists($id, $domainsBonuses)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Invalid %s argument sent. It must be an array of %s, and the array key must correspond to the "%s" property.',
                        '$domainsBonuses', 'integers', 'domain id'
                    ));
                }
                $this->finalCalculatedDomains[$id] += $domainsBonuses[$id];
            }
        }

        /**
         * Ost service
         */
        if (!array_key_exists($ost, $allDomains)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid %s argument sent. It must be a valid %s.',
                '$ost', 'domain id'
            ));
        }
        $this->addValueToDomain($ost);

        /**
         * "Scholar" advantage
         */
        if (null !== $scholar) {
            if (!array_key_exists($scholar, $allDomains)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid %s argument sent. It must be a valid %s.',
                    '$scholar', 'domain id'
                ));
            }
            $this->addValueToDomain($scholar);
        }

        /**
         * Geo environment
         */
        $this->addValueToDomain($geoEnv->getId());

        /**
         * Social classes
         */
        foreach ($socialClasses as $id) {
            if (!array_key_exists($id, $allDomains)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid %s argument sent. It must be an array of %s, and the array values must correspond to the "%s" property.',
                    '$socialClasses', 'integers', 'domain id'
                ));
            }

            $this->addValueToDomain($id);
        }

        if (null !== $domainsBonuses) {
            foreach ($this->finalCalculatedDomains as $id => $value) {
                if ($value > 5) {
                    $this->finalCalculatedDomains[$id] = 5;
                }
            }
        }

        return $this->finalCalculatedDomains;
    }

    /**
     * @return int
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * @param int $domainId
     * @param int $value
     */
    private function addValueToDomain($domainId, $value = 1)
    {
        if (1 === $value) {
            if ($this->finalCalculatedDomains[$domainId] <= 5) {
                $this->finalCalculatedDomains[$domainId]++;
            } else {
                $this->bonus++;
            }
        } else {
            for ($i = 1; $i <= $value; $i++) {
                $this->addValueToDomain($domainId);
            }
        }
    }
}
