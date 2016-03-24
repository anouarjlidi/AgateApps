<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Disorders;
use CorahnRin\CorahnRinBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DisordersFixtures extends AbstractFixture implements OrderedFixtureInterface
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
    public function getOrder()
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinBundle:Disorders');

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, 'Frénésie', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 2, 'Exaltation', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 3, 'Mélancolie', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 4, 'Hallucination', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 5, 'Confusion mentale', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 6, 'Mimétisme', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 7, 'Obsession', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 8, 'Hystérie', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 9, 'Mysticisme', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 10, 'Paranoïa', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $created, $updated, $deleted = null, $book)
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
            $obj = new Disorders();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setBook($book)
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
            $this->addReference('corahnrin-disorder-'.$id, $obj);
        }
    }
}
