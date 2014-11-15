<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\GeoEnvironments;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class GeoEnvironmentsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

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

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:GeoEnvironments');

        $book = $this->getReference('corahnrin-book-2');
        $domain5 = $this->getReference('corahnrin-domain-5');
        $domain11 = $this->getReference('corahnrin-domain-11');

        $this->fixtureObject($repo, 1, $domain5, 'Rural', 'Votre personnage est issu d\'une campagne ou d\'un lieu relativement isolé.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 2, $domain11, 'Urbain', 'Votre personnage a vécu longtemps dans une ville, suffisamment pour qu\'il ait adopté les codes de la ville dans son mode de vie.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $domain, $name, $description, $created, $updated, $deleted = null, $book)
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
        if ($newObject === true) {
            $obj = new GeoEnvironments();
            $obj->setId($id)
                ->setName($name)
                ->setDomain($domain)
                ->setBook($book)
                ->setDescription($description)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-geo-environment-'.$id, $obj);
        }
    }
}