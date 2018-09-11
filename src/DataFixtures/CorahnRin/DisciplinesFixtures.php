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

use CorahnRin\Data\DomainsData;
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
     */
    public function getOrder(): int
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository(\CorahnRin\Entity\Disciplines::class);

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1, 'Acrobaties', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 2, 'Agriculture', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 3, 'Arbalètes', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SHOOTING_AND_THROWING['title']], $book);
        $this->fixtureObject($repo, 4, 'Architecture', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 5, 'Arcs', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SHOOTING_AND_THROWING['title']], $book);
        $this->fixtureObject($repo, 6, 'Armes contondantes', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 7, 'Armes de jet', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SHOOTING_AND_THROWING['title']], $book);
        $this->fixtureObject($repo, 8, 'Artefact de combat', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title'], DomainsData::OCCULTISM['title'], DomainsData::SCIENCE['title'], DomainsData::SHOOTING_AND_THROWING['title']], $book);
        $this->fixtureObject($repo, 9, 'Attelage', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 10, 'Baratin', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 11, 'Bâtons', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 12, 'Bijouterie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 13, 'Botanique', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 14, 'Camouflage', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::STEALTH['title']], $book);
        $this->fixtureObject($repo, 15, 'Cartographie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 16, 'Chant', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 17, 'Charme', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 18, 'Chemins de traverse (Varigal)', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 19, 'Combat à mains nues', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 20, 'Combat aveugle', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 21, 'Comédie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 22, 'Commandement', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 23, 'Concentration', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title'], DomainsData::PRAYER['title']], $book);
        $this->fixtureObject($repo, 24, 'Confection', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 25, 'Conn. troubles mentaux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 26, 'Conn. d\'une faction', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 27, 'Conn. des Flux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title']], $book);
        $this->fixtureObject($repo, 28, 'Conn. du Temple', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PRAYER['title']], $book);
        $this->fixtureObject($repo, 29, 'Course', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 30, 'Cuisine', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 31, 'Danse', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 32, 'Diplomatie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 33, 'Distillation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 34, 'Doctrine du Temple', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 35, 'Dressage d\'animaux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 36, 'Endurance', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 37, 'Épées', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 38, 'Équitation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 39, 'Escalade', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 40, 'Ésotérisme', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::OCCULTISM['title']], $book);
        $this->fixtureObject($repo, 41, 'Étiquette d\'un milieu social', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 42, 'Évaluation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERCEPTION['title']], $book);
        $this->fixtureObject($repo, 43, 'Évasion', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 44, 'Extraction de Flux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title']], $book);
        $this->fixtureObject($repo, 45, 'Extraction minière', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 46, 'Faune et flore', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 47, 'Forge', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 48, 'Furtivité', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::STEALTH['title']], $book);
        $this->fixtureObject($repo, 49, 'Géographie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 50, 'Géologie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 51, 'Haches', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 52, 'Héraldique', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 53, 'Herboristerie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title'], DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 54, 'Histoire', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 55, 'Hypnose', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::OCCULTISM['title']], $book);
        $this->fixtureObject($repo, 56, 'Ingénierie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 57, 'Instrument de musique', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 58, 'Interprétation des rêves', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::OCCULTISM['title']], $book);
        $this->fixtureObject($repo, 59, 'Intimidation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 60, 'Jeux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 61, 'Jonglage', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 62, 'Lames courtes', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 63, 'Langue ancienne', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title']], $book);
        $this->fixtureObject($repo, 64, 'Langues', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 65, 'Lecture sur les lèvres', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERCEPTION['title']], $book);
        $this->fixtureObject($repo, 66, 'Machinerie magientiste', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title'], DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 67, 'Maroquinerie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 68, 'Mécanique', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 69, 'Médecine', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title'], DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 70, 'Médecine traditionnelle', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title']], $book);
        $this->fixtureObject($repo, 71, 'Méditation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title']], $book);
        $this->fixtureObject($repo, 72, 'Menuiserie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 73, 'Mimétisme', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::STEALTH['title']], $book);
        $this->fixtureObject($repo, 74, 'Miracles', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PRAYER['title']], $book);
        $this->fixtureObject($repo, 75, 'Natation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 76, 'Navigation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 77, 'Observation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERCEPTION['title']], $book);
        $this->fixtureObject($repo, 78, 'Orientation', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title'], DomainsData::PERCEPTION['title'], DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 79, 'Outil magientiste', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title'], DomainsData::OCCULTISM['title'], DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 80, 'Peinture', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 81, 'Persuasion', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::RELATION['title']], $book);
        $this->fixtureObject($repo, 82, 'Phénomènes mentaux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::OCCULTISM['title']], $book);
        $this->fixtureObject($repo, 83, 'Pistage', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 84, 'Politique', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 85, 'Poterie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 86, 'Premiers soins', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 87, 'Principes magientistes', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 88, 'Raffinage de Flux', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title']], $book);
        $this->fixtureObject($repo, 89, 'Recueillement', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PRAYER['title']], $book);
        $this->fixtureObject($repo, 90, 'Réparation d\'artefacts', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title'], DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 91, 'Savoirs demorthèn', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title']], $book);
        $this->fixtureObject($repo, 92, 'Sculpture', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 93, 'Sens aiguisés', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERCEPTION['title']], $book);
        $this->fixtureObject($repo, 94, 'Serrurerie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CRAFT['title']], $book);
        $this->fixtureObject($repo, 95, 'Sigil Rann', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title']], $book);
        $this->fixtureObject($repo, 96, 'Signes (Varigal)', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::TRAVEL['title']], $book);
        $this->fixtureObject($repo, 97, 'Spiritualité', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::DEMORTHEN_MYSTERIES['title'], DomainsData::PRAYER['title'], DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 98, 'Survie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::NATURAL_ENVIRONMENT['title']], $book);
        $this->fixtureObject($repo, 99, 'Traditions demorthèn', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 100, 'Utilisation d\'artefacts', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::MAGIENCE['title']], $book);
        $this->fixtureObject($repo, 101, 'Ventriloquie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERFORMANCE['title']], $book);
        $this->fixtureObject($repo, 102, 'Vigilance', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::PERCEPTION['title']], $book);
        $this->fixtureObject($repo, 103, 'Vol à la tire', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::STEALTH['title']], $book);
        $this->fixtureObject($repo, 104, 'Zoologie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);
        $this->fixtureObject($repo, 105, 'Armes d\'hast', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::CLOSE_COMBAT['title']], $book);
        $this->fixtureObject($repo, 106, 'Astronomie', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 107, 'Légendes', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::ERUDITION['title']], $book);
        $this->fixtureObject($repo, 108, 'Travail de force', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::FEATS['title']], $book);
        $this->fixtureObject($repo, 109, 'Traitement de l\'esprit', '', Disciplines::RANK_PROFESSIONAL, [DomainsData::SCIENCE['title']], $book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, ?int $id, string $name, string $description, string $rank, array $domains, Books $book)
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
            $obj = new Disciplines();
            $obj->setId($id);
            $obj->setName($name);
            $obj->setDescription($description);
            $obj->setRank($rank);
            $obj->setBook($book);
            $obj->setDomains($domains);
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetadata(\get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if (true === $addRef && $obj) {
            $this->addReference('corahnrin-discipline-'.$id, $obj);
        }
    }
}
