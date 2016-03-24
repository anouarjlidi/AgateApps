<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Disciplines;
use CorahnRin\CorahnRinBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DisciplinesFixtures extends AbstractFixture implements OrderedFixtureInterface
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

        $repo = $this->manager->getRepository('CorahnRinBundle:Disciplines');

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, 'Acrobaties', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 2, 'Agriculture', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 3, 'Arbalètes', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 4, 'Architecture', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 5, 'Arcs', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 6, 'Armes contondantes', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 7, 'Armes de jet', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 8, 'Artefact de combat', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 9, 'Attelage', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 10, 'Baratin', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 11, 'Bâtons', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 12, 'Bijouterie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 13, 'Botanique', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 14, 'Camouflage', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 15, 'Cartographie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 16, 'Chant', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 17, 'Charme', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 18, 'Chemins de traverse (Varigal)', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 19, 'Combat à mains nues', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 20, 'Combat aveugle', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 21, 'Comédie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 22, 'Commandement', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 23, 'Concentration', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 24, 'Confection', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 25, 'Conn. troubles mentaux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 26, 'Conn. d\'une faction', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 27, 'Conn. des Flux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 28, 'Conn. du Temple', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 29, 'Course', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 30, 'Cuisine', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 31, 'Danse', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 32, 'Diplomatie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 33, 'Distillation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 34, 'Doctrine du Temple', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 35, 'Dressage d\'animaux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 36, 'Endurance', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 37, 'Épées', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 38, 'Équitation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 39, 'Escalade', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 40, 'Ésotérisme', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 41, 'Étiquette d\'un milieu social', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 42, 'Évaluation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 43, 'Évasion', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 44, 'Extraction de Flux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 45, 'Extraction minière', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 46, 'Faune et flore', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 47, 'Forge', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 48, 'Furtivité', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 49, 'Géographie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 50, 'Géologie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 51, 'Haches', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 52, 'Héraldique', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 53, 'Herboristerie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 54, 'Histoire', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 55, 'Hypnose', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 56, 'Ingénierie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 57, 'Instrument de musique', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 58, 'Interprétation des rêves', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 59, 'Intimidation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 60, 'Jeux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 61, 'Jonglage', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 62, 'Lames courtes', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 63, 'Langue ancienne', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 64, 'Langues', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 65, 'Lecture sur les lèvres', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 66, 'Machinerie magientiste', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 67, 'Maroquinerie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 68, 'Mécanique', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 69, 'Médecine', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 70, 'Médecine traditionnelle', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 71, 'Méditation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 72, 'Menuiserie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 73, 'Mimétisme', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 74, 'Miracles', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 75, 'Natation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 76, 'Navigation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 77, 'Observation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 78, 'Orientation', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 79, 'Outil magientiste', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 80, 'Peinture', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 81, 'Persuasion', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 82, 'Phénomènes mentaux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 83, 'Pistage', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 84, 'Politique', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 85, 'Poterie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 86, 'Premiers soins', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 87, 'Principes magientistes', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 88, 'Raffinage de Flux', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 89, 'Recueillement', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 90, 'Réparation d\'artefacts', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 91, 'Savoirs demorthèn', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 92, 'Sculpture', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 93, 'Sens aiguisés', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 94, 'Serrurerie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 95, 'Sigil Rann', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 96, 'Signes (Varigal)', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 97, 'Spiritualité', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 98, 'Survie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 99, 'Traditions demorthèn', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 100, 'Utilisation d\'artefacts', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 101, 'Ventriloquie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 102, 'Vigilance', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 103, 'Vol à la tire', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 104, 'Zoologie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 105, 'Armes d\'hast', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 106, 'Astronomie', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 107, 'Légendes', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 108, 'Travail de force', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);
        $this->fixtureObject($repo, 109, 'Traitement de l\'esprit', '', 'Professionnel', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $rank, $created, $updated, $deleted = null, $book)
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
            $obj = new Disciplines();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setRank($rank)
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
            $this->addReference('corahnrin-discipline-'.$id, $obj);
        }
    }
}
