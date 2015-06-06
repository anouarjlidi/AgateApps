<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;

class ZonesTypesFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ZonesTypes[]
     */
    private $zonesTypes = array();

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 0;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:ZonesTypes');

        $this->fixtureObject($repo, 1, null, 'Politique', '', '');
        $this->fixtureObject($repo, 2, 1, 'Royaume', '', '#E05151');
        $this->fixtureObject($repo, 3, 1, 'Territoire', '', '#E4AA8E');
        $this->fixtureObject($repo, 4, 1, 'Domaine', '', '#BBA748');
        $this->fixtureObject($repo, 5, 1, 'Ville / Village', '', '#F1E091');
        $this->fixtureObject($repo, 6, 1, 'Terre sacrée', '', '#CCA9D9');
        $this->fixtureObject($repo, 7, null, 'Terrain', '', '');
        $this->fixtureObject($repo, 8, 7, 'Forêt', '', '#669D4E');
        $this->fixtureObject($repo, 9, 7, 'Marais', '', '#748F43');
        $this->fixtureObject($repo, 10, 7, 'Montagnes', '', '#A6A6A6');
        $this->fixtureObject($repo, 11, 7, 'Failles / Falaises', '', '#756098');
        $this->fixtureObject($repo, 12, 7, 'Landes', '', '#9F8F50');
        $this->fixtureObject($repo, 13, 7, 'Mer, lac', '', '#7099E4');
        $this->fixtureObject($repo, 14, 7, 'Île(s)', '', '#6367AA');
        $this->fixtureObject($repo, 15, 7, 'Collines', '', '');
        $this->fixtureObject($repo, 16, 7, 'Plage(s)', '', '');
        $this->fixtureObject($repo, 17, 7, 'Plaine(s)', '', '');
        $this->fixtureObject($repo, 18, 7, 'Plateau', '', '');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $parent, $name, $description, $color)
    {
        $obj       = null;
        $newObject = false;
        $addRef    = false;
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
        if ($newObject === true) {
            $obj = new ZonesTypes();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setColor($color)
            ;
            if ($parent) {
                if (!isset($this->zonesTypes[$parent])) {
                    $this->zonesTypes[$parent] = $this->getReference('esterenmaps-zonestypes-'.$parent);
                }
                $obj->setParent($this->zonesTypes[$parent]);
            }
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('esterenmaps-zonestypes-'.$id, $obj);
        }
    }
}