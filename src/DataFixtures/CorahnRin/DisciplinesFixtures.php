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

use CorahnRin\Entity\Books;
use CorahnRin\Entity\Disciplines;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class DisciplinesFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
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

        $repo = $this->manager->getRepository(\CorahnRin\Entity\Disciplines::class);

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, 'Acrobaties', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 2, 'Agriculture', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 3, 'Arbalètes', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 4, 'Architecture', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 5, 'Arcs', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 6, 'Armes contondantes', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 7, 'Armes de jet', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 8, 'Artefact de combat', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 9, 'Attelage', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 10, 'Baratin', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 11, 'Bâtons', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 12, 'Bijouterie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 13, 'Botanique', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 14, 'Camouflage', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 15, 'Cartographie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 16, 'Chant', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 17, 'Charme', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 18, 'Chemins de traverse (Varigal)', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 19, 'Combat à mains nues', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 20, 'Combat aveugle', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 21, 'Comédie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 22, 'Commandement', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 23, 'Concentration', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 24, 'Confection', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 25, 'Conn. troubles mentaux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 26, 'Conn. d\'une faction', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 27, 'Conn. des Flux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 28, 'Conn. du Temple', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 29, 'Course', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 30, 'Cuisine', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 31, 'Danse', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 32, 'Diplomatie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 33, 'Distillation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 34, 'Doctrine du Temple', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 35, 'Dressage d\'animaux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 36, 'Endurance', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 37, 'Épées', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 38, 'Équitation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 39, 'Escalade', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 40, 'Ésotérisme', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 41, 'Étiquette d\'un milieu social', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 42, 'Évaluation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 43, 'Évasion', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 44, 'Extraction de Flux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 45, 'Extraction minière', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 46, 'Faune et flore', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 47, 'Forge', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 48, 'Furtivité', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 49, 'Géographie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 50, 'Géologie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 51, 'Haches', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 52, 'Héraldique', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 53, 'Herboristerie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 54, 'Histoire', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 55, 'Hypnose', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 56, 'Ingénierie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 57, 'Instrument de musique', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 58, 'Interprétation des rêves', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 59, 'Intimidation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 60, 'Jeux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 61, 'Jonglage', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 62, 'Lames courtes', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 63, 'Langue ancienne', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 64, 'Langues', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 65, 'Lecture sur les lèvres', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 66, 'Machinerie magientiste', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 67, 'Maroquinerie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 68, 'Mécanique', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 69, 'Médecine', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 70, 'Médecine traditionnelle', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 71, 'Méditation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 72, 'Menuiserie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 73, 'Mimétisme', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 74, 'Miracles', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 75, 'Natation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 76, 'Navigation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 77, 'Observation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 78, 'Orientation', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 79, 'Outil magientiste', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 80, 'Peinture', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 81, 'Persuasion', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 82, 'Phénomènes mentaux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 83, 'Pistage', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 84, 'Politique', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 85, 'Poterie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 86, 'Premiers soins', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 87, 'Principes magientistes', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 88, 'Raffinage de Flux', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 89, 'Recueillement', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 90, 'Réparation d\'artefacts', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 91, 'Savoirs demorthèn', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 92, 'Sculpture', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 93, 'Sens aiguisés', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 94, 'Serrurerie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 95, 'Sigil Rann', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 96, 'Signes (Varigal)', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 97, 'Spiritualité', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 98, 'Survie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 99, 'Traditions demorthèn', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 100, 'Utilisation d\'artefacts', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 101, 'Ventriloquie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 102, 'Vigilance', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 103, 'Vol à la tire', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 104, 'Zoologie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 105, 'Armes d\'hast', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 106, 'Astronomie', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 107, 'Légendes', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 108, 'Travail de force', '', 'Professionnel', $book);
        $this->fixtureObject($repo, 109, 'Traitement de l\'esprit', '', 'Professionnel', $book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $rank, $book)
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
            $obj = new Disciplines();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setRank($rank)
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
            $this->addReference('corahnrin-discipline-'.$id, $obj);
        }
    }
}
