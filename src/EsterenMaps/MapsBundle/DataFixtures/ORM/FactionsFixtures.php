<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\Factions;

class FactionsFixtures extends AbstractFixture implements OrderedFixtureInterface
{

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
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:Factions');

        /** @var Books $book */
        $book1 = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, $book1, 'Temple', ' Les adeptes de la religion de l\'Unique.');
        $this->fixtureObject($repo, 2, $book1, 'Magience', 'Les partisans d\'une société régie par des principes académiques & scientifiques.');
        $this->fixtureObject($repo, 3, $book1, 'Démorthèn', 'Les populations honorant les cultes et traditions ancestrales de Tri-Kazel. ');
        $this->fixtureObject($repo, 4, $book1, 'Neutre', 'Aucun des grands courants idéologiques ne dominent ce lieu.');
        $this->fixtureObject($repo, 5, $book1, 'Osags', 'Rattachés au culte demorthèn, les Osags en sont peut-être l\'expression la plus radicale.');
        $this->fixtureObject($repo, 6, $book1, 'Tarish', 'Peuple nomade par excellence, ses communautés sont en mouvement constant.');
        //$this->fixtureObject($repo, 7, $book1, 'Loge botaniste', 'L\'école magientiste appliquée aux plantes, herbes et végétaux en général.');
        //$this->fixtureObject($repo, 8, $book1, 'Loge minéraliste', 'L\'école magientiste appliquée aux pierres, métaux et minéraux en général.');
        $this->fixtureObject($repo, 9, $book1, 'Noblesse', 'La noblesse défend des valeurs de tradition, hiérarchie, autorité. Certains nobles sont très dévoués à leur souverain, d\'autres estiment qu\'ils sont seuls maîtres sur leurs terres.');
        $this->fixtureObject($repo, 10, $book1, 'Marchand', 'Les marchands sont essentiellement pragmatiques : partisans de la circulation des biens et des personnes, et de législations qui leur permettent de s\'enrichir. Ils peuvent s\'accommoder d\'un peu de corruption, mais veulent des routes sûres.');
        $this->fixtureObject($repo, 11, $book1, 'Mixte', 'Plusieurs courants se partagent ou se disputent les lieux sans qu\'il soit véritablement possible de discerner la domination de l\'un d\'eux.');
        $this->fixtureObject($repo, 12, $book1, 'Rebelles & Criminels', 'Les individus qui dominent sont en rupture avec la société, pour des raisons d\'intérêt ou d\'opinion. Le territoire est une zone grise, où la violence est endémique.');
        $this->fixtureObject($repo, 13, $book1, 'Chevaliers Ronce', 'Les Ronces sont un ordre très ancien dont les activités sont partagées entre la lutte contre les feondas et la gestion d\'organismes bancaires.');
        $this->fixtureObject($repo, 14, $book1, 'Chevaliers Hilderins', 'Cet ordre de chevalerie, très lié à la couronne talkéride, est voué à la lutte contre les feondas et peu à l\'occasion assurer la régence d\'un domaine.');
        $this->fixtureObject($repo, 15, $book1, 'Varigaux', 'Ces guides et messagers arpentent les chemins de la péninsule, assurant le lien entre les communautés les plus isolées. Ils connaissent souvent des raccourcis.');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $book, $name, $description)
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
            $obj = new Factions();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setBook($book)
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