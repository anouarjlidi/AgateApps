<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFixtures\CorahnRin;

use CorahnRin\Data\Ways;
use CorahnRin\Entity\Domains;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DomainsFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder(): int
    {
        return 3;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository(\CorahnRin\Entity\Domains::class);

        $way1 = Ways::COMBATIVENESS;
        $way2 = Ways::CREATIVITY;
        $way3 = Ways::EMPATHY;
        $way4 = Ways::REASON;
        $way5 = Ways::CONVICTION;

        $this->fixtureObject($repo, 1, $way2, 'Artisanat', '');
        $this->fixtureObject($repo, 2, $way1, 'Combat au Contact', '');
        $this->fixtureObject($repo, 3, $way3, 'Discrétion', '');
        $this->fixtureObject($repo, 4, $way4, 'Magience', '');
        $this->fixtureObject($repo, 5, $way3, 'Milieu Naturel', '');
        $this->fixtureObject($repo, 6, $way3, 'Mystères Demorthèn', '');
        $this->fixtureObject($repo, 7, $way4, 'Occultisme', '');
        $this->fixtureObject($repo, 8, $way4, 'Perception', '');
        $this->fixtureObject($repo, 9, $way5, 'Prière', '');
        $this->fixtureObject($repo, 10, $way1, 'Prouesses', '');
        $this->fixtureObject($repo, 11, $way3, 'Relation', '');
        $this->fixtureObject($repo, 12, $way2, 'Représentation', '');
        $this->fixtureObject($repo, 13, $way4, 'Science', '');
        $this->fixtureObject($repo, 14, $way1, 'Tir et Lancer', '');
        $this->fixtureObject($repo, 15, $way3, 'Voyage', '');
        $this->fixtureObject($repo, 16, $way4, 'Érudition', '');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $way, $name, $description)
    {
        $obj = null;
        $newObject = false;
        $addRef = false;
        if ($id) {
            $obj = $repo->find($id);
            if ($obj) {
                $addRef = true;
            } else {
                $newObject = true;
            }
        } else {
            $newObject = true;
        }
        if (true === $newObject) {
            $obj = new Domains();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setWay($way)
            ;
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetadata(\get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if (true === $addRef && $obj) {
            $this->addReference('corahnrin-domain-'.$id, $obj);
        }
    }
}
