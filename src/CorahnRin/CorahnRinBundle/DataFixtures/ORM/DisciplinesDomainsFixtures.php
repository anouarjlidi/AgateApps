<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Disciplines;
use CorahnRin\CorahnRinBundle\Entity\Domains;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DisciplinesDomainsFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var Domains[]
     */
    private $domains = [];

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $discRepo = $this->manager->getRepository('CorahnRinBundle:Disciplines');
        $domRepo  = $this->manager->getRepository('CorahnRinBundle:Domains');

        $this->fixtureObject($discRepo, $domRepo, 1, [10]);
        $this->fixtureObject($discRepo, $domRepo, 2, [5]);
        $this->fixtureObject($discRepo, $domRepo, 3, [14]);
        $this->fixtureObject($discRepo, $domRepo, 4, [13]);
        $this->fixtureObject($discRepo, $domRepo, 5, [14]);
        $this->fixtureObject($discRepo, $domRepo, 6, [2]);
        $this->fixtureObject($discRepo, $domRepo, 7, [14]);
        $this->fixtureObject($discRepo, $domRepo, 8, [2, 7, 13, 14]);
        $this->fixtureObject($discRepo, $domRepo, 9, [15]);
        $this->fixtureObject($discRepo, $domRepo, 10, [11]);
        $this->fixtureObject($discRepo, $domRepo, 11, [2]);
        $this->fixtureObject($discRepo, $domRepo, 12, [1]);
        $this->fixtureObject($discRepo, $domRepo, 13, [13]);
        $this->fixtureObject($discRepo, $domRepo, 14, [3]);
        $this->fixtureObject($discRepo, $domRepo, 15, [15]);
        $this->fixtureObject($discRepo, $domRepo, 16, [12]);
        $this->fixtureObject($discRepo, $domRepo, 17, [11]);
        $this->fixtureObject($discRepo, $domRepo, 18, [15]);
        $this->fixtureObject($discRepo, $domRepo, 19, [2]);
        $this->fixtureObject($discRepo, $domRepo, 20, [2]);
        $this->fixtureObject($discRepo, $domRepo, 21, [12]);
        $this->fixtureObject($discRepo, $domRepo, 22, [11]);
        $this->fixtureObject($discRepo, $domRepo, 23, [6, 9]);
        $this->fixtureObject($discRepo, $domRepo, 24, [1]);
        $this->fixtureObject($discRepo, $domRepo, 25, [13]);
        $this->fixtureObject($discRepo, $domRepo, 26, [11]);
        $this->fixtureObject($discRepo, $domRepo, 27, [4]);
        $this->fixtureObject($discRepo, $domRepo, 28, [9]);
        $this->fixtureObject($discRepo, $domRepo, 29, [10]);
        $this->fixtureObject($discRepo, $domRepo, 30, [1]);
        $this->fixtureObject($discRepo, $domRepo, 31, [12]);
        $this->fixtureObject($discRepo, $domRepo, 32, [11]);
        $this->fixtureObject($discRepo, $domRepo, 33, [1]);
        $this->fixtureObject($discRepo, $domRepo, 34, [16]);
        $this->fixtureObject($discRepo, $domRepo, 35, [5]);
        $this->fixtureObject($discRepo, $domRepo, 36, [10]);
        $this->fixtureObject($discRepo, $domRepo, 37, [2]);
        $this->fixtureObject($discRepo, $domRepo, 38, [15]);
        $this->fixtureObject($discRepo, $domRepo, 39, [10]);
        $this->fixtureObject($discRepo, $domRepo, 40, [7]);
        $this->fixtureObject($discRepo, $domRepo, 41, [11]);
        $this->fixtureObject($discRepo, $domRepo, 42, [8]);
        $this->fixtureObject($discRepo, $domRepo, 43, [10]);
        $this->fixtureObject($discRepo, $domRepo, 44, [4]);
        $this->fixtureObject($discRepo, $domRepo, 45, [1]);
        $this->fixtureObject($discRepo, $domRepo, 46, [5]);
        $this->fixtureObject($discRepo, $domRepo, 47, [1]);
        $this->fixtureObject($discRepo, $domRepo, 48, [3]);
        $this->fixtureObject($discRepo, $domRepo, 49, [16]);
        $this->fixtureObject($discRepo, $domRepo, 50, [13]);
        $this->fixtureObject($discRepo, $domRepo, 51, [2]);
        $this->fixtureObject($discRepo, $domRepo, 52, [16]);
        $this->fixtureObject($discRepo, $domRepo, 53, [6, 16]);
        $this->fixtureObject($discRepo, $domRepo, 54, [16]);
        $this->fixtureObject($discRepo, $domRepo, 55, [7]);
        $this->fixtureObject($discRepo, $domRepo, 56, [13]);
        $this->fixtureObject($discRepo, $domRepo, 57, [12]);
        $this->fixtureObject($discRepo, $domRepo, 58, [7]);
        $this->fixtureObject($discRepo, $domRepo, 59, [11]);
        $this->fixtureObject($discRepo, $domRepo, 60, [12]);
        $this->fixtureObject($discRepo, $domRepo, 61, [12]);
        $this->fixtureObject($discRepo, $domRepo, 62, [2]);
        $this->fixtureObject($discRepo, $domRepo, 63, [6]);
        $this->fixtureObject($discRepo, $domRepo, 64, [16]);
        $this->fixtureObject($discRepo, $domRepo, 65, [8]);
        $this->fixtureObject($discRepo, $domRepo, 66, [1, 13]);
        $this->fixtureObject($discRepo, $domRepo, 67, [1]);
        $this->fixtureObject($discRepo, $domRepo, 68, [13]);
        $this->fixtureObject($discRepo, $domRepo, 69, [4, 13]);
        $this->fixtureObject($discRepo, $domRepo, 70, [6]);
        $this->fixtureObject($discRepo, $domRepo, 71, [6]);
        $this->fixtureObject($discRepo, $domRepo, 72, [1]);
        $this->fixtureObject($discRepo, $domRepo, 73, [3]);
        $this->fixtureObject($discRepo, $domRepo, 74, [9]);
        $this->fixtureObject($discRepo, $domRepo, 75, [10]);
        $this->fixtureObject($discRepo, $domRepo, 76, [15]);
        $this->fixtureObject($discRepo, $domRepo, 77, [8]);
        $this->fixtureObject($discRepo, $domRepo, 78, [5, 8, 15]);
        $this->fixtureObject($discRepo, $domRepo, 79, [1, 7, 13]);
        $this->fixtureObject($discRepo, $domRepo, 80, [1]);
        $this->fixtureObject($discRepo, $domRepo, 81, [11]);
        $this->fixtureObject($discRepo, $domRepo, 82, [7]);
        $this->fixtureObject($discRepo, $domRepo, 83, [5]);
        $this->fixtureObject($discRepo, $domRepo, 84, [16]);
        $this->fixtureObject($discRepo, $domRepo, 85, [1]);
        $this->fixtureObject($discRepo, $domRepo, 86, [5]);
        $this->fixtureObject($discRepo, $domRepo, 87, [16]);
        $this->fixtureObject($discRepo, $domRepo, 88, [4]);
        $this->fixtureObject($discRepo, $domRepo, 89, [9]);
        $this->fixtureObject($discRepo, $domRepo, 90, [4, 13]);
        $this->fixtureObject($discRepo, $domRepo, 91, [6]);
        $this->fixtureObject($discRepo, $domRepo, 92, [1]);
        $this->fixtureObject($discRepo, $domRepo, 93, [8]);
        $this->fixtureObject($discRepo, $domRepo, 94, [1]);
        $this->fixtureObject($discRepo, $domRepo, 95, [6]);
        $this->fixtureObject($discRepo, $domRepo, 96, [15]);
        $this->fixtureObject($discRepo, $domRepo, 97, [6, 9, 13]);
        $this->fixtureObject($discRepo, $domRepo, 98, [5]);
        $this->fixtureObject($discRepo, $domRepo, 99, [16]);
        $this->fixtureObject($discRepo, $domRepo, 100, [4]);
        $this->fixtureObject($discRepo, $domRepo, 101, [12]);
        $this->fixtureObject($discRepo, $domRepo, 102, [8]);
        $this->fixtureObject($discRepo, $domRepo, 103, [3]);
        $this->fixtureObject($discRepo, $domRepo, 104, [13]);
        $this->fixtureObject($discRepo, $domRepo, 105, [2]);
        $this->fixtureObject($discRepo, $domRepo, 106, [16]);
        $this->fixtureObject($discRepo, $domRepo, 107, [16]);
        $this->fixtureObject($discRepo, $domRepo, 108, [10]);
        $this->fixtureObject($discRepo, $domRepo, 109, [13]);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $discRepo, EntityRepository $domRepo, $disciplineId, array $domains)
    {
        $discipline = null;
        /** @var Disciplines $discipline */
        $discipline = $discRepo->find($disciplineId);
        if (!$discipline) {
            throw new \Exception('Discipline with id "'.$disciplineId.'" does not exist.');
        }
        foreach ($domains as $id) {
            /* @var Domains $domain */
            if (isset($this->domains[$id])) {
                $domain = $this->domains[$id];
            } else {
                $domain = $domRepo->find($id);
                if (!$domain) {
                    throw new \Exception('Domain with id "'.$id.'" does not exist.');
                }
                $this->domains[$id] = $domain;
            }
            if (!$domain->hasDiscipline($discipline)) {
                $discipline->addDomain($domain);
                $domain->addDiscipline($discipline);
                if (!$this->manager->getUnitOfWork()->isEntityScheduled($domain)) {
                    $this->manager->persist($domain);
                }
            }
        }
        $this->manager->persist($discipline);
    }
}
