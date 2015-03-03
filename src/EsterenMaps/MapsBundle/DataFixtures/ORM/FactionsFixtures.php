<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use CorahnRin\ModelsBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\Factions;

class FactionsFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:Factions');

        /** @var Books $book */
        $book1 = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, $book1, 'Temple', 'Les adeptes de la religion du Temple.', '2014-02-05 15:27:32', '2014-02-05 15:27:32', null);
        $this->fixtureObject($repo, 2, $book1, 'Magience', 'Les partisans d\'une société régie par des principes académiques & scientifiques.', '2014-02-05 15:29:24', '2014-02-05 15:29:24', null);
        $this->fixtureObject($repo, 3, $book1, 'Démorthèn', 'Les populations honorant les cultes et traditions ancestrales de Tri Kazel.', '2014-02-05 15:30:48', '2014-02-05 15:30:48', null);
        $this->fixtureObject($repo, 4, $book1, 'Neutre', 'Aucun des grands courants idéologiques ne dominent ce lieu.', '2014-02-05 15:34:04', '2014-02-05 15:34:04', null);
        $this->fixtureObject($repo, 5, $book1, 'Osags', 'Rattachés au culte Démorthèn, les Osags en sont peut être l\'expression la plus radicale.', '2014-02-05 15:35:35', '2014-02-05 15:35:35', null);
        $this->fixtureObject($repo, 6, $book1, 'Tarish', 'Peuple nomade par excellence, ses communautés sont en mouvement constant.', '2014-02-05 15:38:04', '2014-02-05 15:38:04', null);
        $this->fixtureObject($repo, 7, $book1, 'Loge botaniste', 'L\'école magientiste appliquée aux plantes, herbes et végétaux en général.', '2014-02-05 15:40:50', '2014-02-05 15:40:50', null);
        $this->fixtureObject($repo, 8, $book1, 'Loge minéraliste', 'L\'école magientiste appliquée aux pierres, métaux et minéraux en général.', '2014-02-05 18:08:38', '2014-02-05 18:08:38', null);
        $this->fixtureObject($repo, 9, $book1, 'Noblesse', 'La noblesse défend des valeurs de tradition, hiérarchie, autorité. Certains nobles sont très dévoués à leur souverain, d\'autres estiment qu\'ils sont seuls maîtres sur leurs terres.', '2014-05-10 17:00:57', '2014-05-10 17:00:57', null);
        $this->fixtureObject($repo, 10, $book1, 'Marchand', 'Les marchands sont essentiellement pragmatiques : partisans de la circulation des biens et des personnes, et de législations qui leur permettent de s\'enrichir. Ils peuvent s\'accommoder d\'un peu de corruption, mais veulent des routes sûres.', '2014-05-10 17:03:14', '2014-05-10 17:03:14', null);
        $this->fixtureObject($repo, 11, $book1, 'Mixte', 'Plusieurs courants se partagent ou se disputent les lieux sans qu\'il soit véritablement possible de discerner la domination de l\'un d\'eux.', '2014-05-10 17:04:14', '2014-05-10 17:04:14', null);
        $this->fixtureObject($repo, 12, $book1, 'Rebelles & Criminels', 'Les individus qui dominent sont en rupture avec la société, pour des raisons d\'intérêt ou d\'opinion. Le territoire est une zone grise, où la violence est endémique.', '2014-05-10 17:05:59', '2014-05-10 17:05:59', null);
        $this->fixtureObject($repo, 13, $book1, 'Chevaliers Ronce', '', '2014-05-10 17:05:59', '2014-05-10 17:05:59', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $book, $name, $description, $created, $updated = null)
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
            $obj = new Factions();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setBook($book)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted(null)
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
            $this->addReference('esterenmaps-factions-'.$id, $obj);
        }
    }
}