<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Disciplines;
use CorahnRin\ModelsBundle\Entity\Domains;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DisciplinesDomainsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var Domains[]
     */
    private $domains = array();

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $discRepo = $this->manager->getRepository('CorahnRinModelsBundle:Disciplines');
        $domRepo = $this->manager->getRepository('CorahnRinModelsBundle:Domains');

        $this->fixtureObject($discRepo, $domRepo, 1, array(10));
        $this->fixtureObject($discRepo, $domRepo, 2, array(5));
        $this->fixtureObject($discRepo, $domRepo, 3, array(14));
        $this->fixtureObject($discRepo, $domRepo, 4, array(13));
        $this->fixtureObject($discRepo, $domRepo, 5, array(14));
        $this->fixtureObject($discRepo, $domRepo, 6, array(2));
        $this->fixtureObject($discRepo, $domRepo, 7, array(14));
        $this->fixtureObject($discRepo, $domRepo, 8, array(2,7,13,14));
        $this->fixtureObject($discRepo, $domRepo, 9, array(15));
        $this->fixtureObject($discRepo, $domRepo, 10, array(11));
        $this->fixtureObject($discRepo, $domRepo, 11, array(2));
        $this->fixtureObject($discRepo, $domRepo, 12, array(1));
        $this->fixtureObject($discRepo, $domRepo, 13, array(13));
        $this->fixtureObject($discRepo, $domRepo, 14, array(3));
        $this->fixtureObject($discRepo, $domRepo, 15, array(15));
        $this->fixtureObject($discRepo, $domRepo, 16, array(12));
        $this->fixtureObject($discRepo, $domRepo, 17, array(11));
        $this->fixtureObject($discRepo, $domRepo, 18, array(15));
        $this->fixtureObject($discRepo, $domRepo, 19, array(2));
        $this->fixtureObject($discRepo, $domRepo, 20, array(2));
        $this->fixtureObject($discRepo, $domRepo, 21, array(12));
        $this->fixtureObject($discRepo, $domRepo, 22, array(11));
        $this->fixtureObject($discRepo, $domRepo, 23, array(6,9));
        $this->fixtureObject($discRepo, $domRepo, 24, array(1));
        $this->fixtureObject($discRepo, $domRepo, 25, array(13));
        $this->fixtureObject($discRepo, $domRepo, 26, array(11));
        $this->fixtureObject($discRepo, $domRepo, 27, array(4));
        $this->fixtureObject($discRepo, $domRepo, 28, array(9));
        $this->fixtureObject($discRepo, $domRepo, 29, array(10));
        $this->fixtureObject($discRepo, $domRepo, 30, array(1));
        $this->fixtureObject($discRepo, $domRepo, 31, array(12));
        $this->fixtureObject($discRepo, $domRepo, 32, array(11));
        $this->fixtureObject($discRepo, $domRepo, 33, array(1));
        $this->fixtureObject($discRepo, $domRepo, 34, array(16));
        $this->fixtureObject($discRepo, $domRepo, 35, array(5));
        $this->fixtureObject($discRepo, $domRepo, 36, array(10));
        $this->fixtureObject($discRepo, $domRepo, 37, array(2));
        $this->fixtureObject($discRepo, $domRepo, 38, array(15));
        $this->fixtureObject($discRepo, $domRepo, 39, array(10));
        $this->fixtureObject($discRepo, $domRepo, 40, array(7));
        $this->fixtureObject($discRepo, $domRepo, 41, array(11));
        $this->fixtureObject($discRepo, $domRepo, 42, array(8));
        $this->fixtureObject($discRepo, $domRepo, 43, array(10));
        $this->fixtureObject($discRepo, $domRepo, 44, array(4));
        $this->fixtureObject($discRepo, $domRepo, 45, array(1));
        $this->fixtureObject($discRepo, $domRepo, 46, array(5));
        $this->fixtureObject($discRepo, $domRepo, 47, array(1));
        $this->fixtureObject($discRepo, $domRepo, 48, array(3));
        $this->fixtureObject($discRepo, $domRepo, 49, array(16));
        $this->fixtureObject($discRepo, $domRepo, 50, array(13));
        $this->fixtureObject($discRepo, $domRepo, 51, array(2));
        $this->fixtureObject($discRepo, $domRepo, 52, array(16));
        $this->fixtureObject($discRepo, $domRepo, 53, array(6,16));
        $this->fixtureObject($discRepo, $domRepo, 54, array(16));
        $this->fixtureObject($discRepo, $domRepo, 55, array(7));
        $this->fixtureObject($discRepo, $domRepo, 56, array(13));
        $this->fixtureObject($discRepo, $domRepo, 57, array(12));
        $this->fixtureObject($discRepo, $domRepo, 58, array(7));
        $this->fixtureObject($discRepo, $domRepo, 59, array(11));
        $this->fixtureObject($discRepo, $domRepo, 60, array(12));
        $this->fixtureObject($discRepo, $domRepo, 61, array(12));
        $this->fixtureObject($discRepo, $domRepo, 62, array(2));
        $this->fixtureObject($discRepo, $domRepo, 63, array(6));
        $this->fixtureObject($discRepo, $domRepo, 64, array(16));
        $this->fixtureObject($discRepo, $domRepo, 65, array(8));
        $this->fixtureObject($discRepo, $domRepo, 66, array(1,13));
        $this->fixtureObject($discRepo, $domRepo, 67, array(1));
        $this->fixtureObject($discRepo, $domRepo, 68, array(13));
        $this->fixtureObject($discRepo, $domRepo, 69, array(4,13));
        $this->fixtureObject($discRepo, $domRepo, 70, array(6));
        $this->fixtureObject($discRepo, $domRepo, 71, array(6));
        $this->fixtureObject($discRepo, $domRepo, 72, array(1));
        $this->fixtureObject($discRepo, $domRepo, 73, array(3));
        $this->fixtureObject($discRepo, $domRepo, 74, array(9));
        $this->fixtureObject($discRepo, $domRepo, 75, array(10));
        $this->fixtureObject($discRepo, $domRepo, 76, array(15));
        $this->fixtureObject($discRepo, $domRepo, 77, array(8));
        $this->fixtureObject($discRepo, $domRepo, 78, array(5,8,15));
        $this->fixtureObject($discRepo, $domRepo, 79, array(1,7,13));
        $this->fixtureObject($discRepo, $domRepo, 80, array(1));
        $this->fixtureObject($discRepo, $domRepo, 81, array(11));
        $this->fixtureObject($discRepo, $domRepo, 82, array(7));
        $this->fixtureObject($discRepo, $domRepo, 83, array(5));
        $this->fixtureObject($discRepo, $domRepo, 84, array(16));
        $this->fixtureObject($discRepo, $domRepo, 85, array(1));
        $this->fixtureObject($discRepo, $domRepo, 86, array(5));
        $this->fixtureObject($discRepo, $domRepo, 87, array(16));
        $this->fixtureObject($discRepo, $domRepo, 88, array(4));
        $this->fixtureObject($discRepo, $domRepo, 89, array(9));
        $this->fixtureObject($discRepo, $domRepo, 90, array(4,13));
        $this->fixtureObject($discRepo, $domRepo, 91, array(6));
        $this->fixtureObject($discRepo, $domRepo, 92, array(1));
        $this->fixtureObject($discRepo, $domRepo, 93, array(8));
        $this->fixtureObject($discRepo, $domRepo, 94, array(1));
        $this->fixtureObject($discRepo, $domRepo, 95, array(6));
        $this->fixtureObject($discRepo, $domRepo, 96, array(15));
        $this->fixtureObject($discRepo, $domRepo, 97, array(6,9,13));
        $this->fixtureObject($discRepo, $domRepo, 98, array(5));
        $this->fixtureObject($discRepo, $domRepo, 99, array(16));
        $this->fixtureObject($discRepo, $domRepo, 100, array(4));
        $this->fixtureObject($discRepo, $domRepo, 101, array(12));
        $this->fixtureObject($discRepo, $domRepo, 102, array(8));
        $this->fixtureObject($discRepo, $domRepo, 103, array(3));
        $this->fixtureObject($discRepo, $domRepo, 104, array(13));
        $this->fixtureObject($discRepo, $domRepo, 105, array(2));
        $this->fixtureObject($discRepo, $domRepo, 106, array(16));
        $this->fixtureObject($discRepo, $domRepo, 107, array(16));
        $this->fixtureObject($discRepo, $domRepo, 108, array(10));
        $this->fixtureObject($discRepo, $domRepo, 109, array(13));

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
            /** @var Domains $domain */
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