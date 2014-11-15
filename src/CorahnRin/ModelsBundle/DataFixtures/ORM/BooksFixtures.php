<?php

namespace CorahnRin\ModelsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class BooksFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
        return 1;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:Books');

        $this->fixtureObject($repo, 1,'Livre 0 - Prologue','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 2,'Livre 1 - Univers','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 3,'Livre 2 - Voyages','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 4,'Livre 2 - Voyages (Réédition)','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 5,'Livre 3 - Dearg Intégrale','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 6,'Livre 3 - Dearg Tome 1','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 7,'Livre 3 - Dearg Tome 2','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 8,'Livre 3 - Dearg Tome 3','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 9,'Livre 3 - Dearg Tome 4','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 10,'Livre 4 - Secrets','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 11,'Livre 5 - Peuples','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 12,'Le Monastère de Tuath','','2014-04-09 08:56:43','2014-04-09 08:56:43',null);
        $this->fixtureObject($repo, 13,'Contenu de la communauté','Ce contenu est par définition non-officiel.','2014-04-09 08:56:43','2014-04-09 08:56:43',null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $created, $updated, $deleted = null)
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
            $obj = new Books();
            $obj->setId($id)
                ->setName($name)
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
            $this->addReference('corahnrin-book-'.$id, $obj);
        }
    }
}