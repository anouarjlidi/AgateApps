<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Jobs;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class JobsFixtures extends AbstractFixture implements OrderedFixtureInterface {

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

        $repo = $this->manager->getRepository('CorahnRinBundle:Jobs');

        $domain1 = $this->getReference('corahnrin-domain-1');
        $domain2 = $this->getReference('corahnrin-domain-2');
        $domain3 = $this->getReference('corahnrin-domain-3');
        $domain4 = $this->getReference('corahnrin-domain-4');
        $domain5 = $this->getReference('corahnrin-domain-5');
        $domain6 = $this->getReference('corahnrin-domain-6');
        $domain7 = $this->getReference('corahnrin-domain-7');
        $domain8 = $this->getReference('corahnrin-domain-8');
        $domain9 = $this->getReference('corahnrin-domain-9');
        $domain10 = $this->getReference('corahnrin-domain-10');
        $domain11 = $this->getReference('corahnrin-domain-11');
        $domain12 = $this->getReference('corahnrin-domain-12');
        $domain13 = $this->getReference('corahnrin-domain-13');
        $domain14 = $this->getReference('corahnrin-domain-14');
        $domain15 = $this->getReference('corahnrin-domain-15');
        $domain16 = $this->getReference('corahnrin-domain-16');

        $book2 = $this->getReference('corahnrin-book-2');
        $book13 = $this->getReference('corahnrin-book-13');

        $this->fixtureObject($repo, 1, $book2, 'Artisan', 'Quel que soit son domaine, l\'artisan est un manuel qualifié.'."\n".'Forgeron, cuisinier, architecte, cordonnier, bûcheron, sculpteur, joailler ; les artisans couvrent un grand nombre de spécialités.'."\n".'Dans les cités où est implantée la magience, on trouve aussi des réparateurs d\'artefacts et des ouvriers spécialisés travaillant dans les usines.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain1);
        $this->fixtureObject($repo, 2, $book2, 'Barde', 'Le statut de barde est hautement honorifique et les plus puissants monarques s\'entourent de ces artistes qui ont de véritables rôles d\'éminence grise.'."\n".'Artiste, acrobate, musicien, bouffon, le barde peut revêtir différents rôles.'."\n".'Il peut également être connu sous d\'autres noms, comme les poètes aveugles filidh ou les étranges céilli de l\'archipel des Tri-Sweszörs.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain12);
        $this->fixtureObject($repo, 3, $book2, 'Chasseur', 'Il nourrit la communauté du produit de ses longues expéditions, qui durent parfois plusieurs jours.'."\n".'L\'expansion des villes a vu l\'apparition de chasseurs d\'un genre nouveau comme les ratiers.'."\n".'D\'autres, comme les Enfants de Neven, dédient leur existence à la traque des feondas.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain5);
        $this->fixtureObject($repo, 4, $book2, 'Chevalier', 'Ces hommes et ces femmes font partie de la noblesse et appartiennent le plus souvent à un ordre de chevalerie comme les Hilderins ou les Ronces.'."\n".'Certains sont des chevaliers errants, derniers héritiers d\'une famille noble ; d\'autres, les vassaux d\'un puissant seigneur.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain2);
        $this->fixtureObject($repo, 5, $book2, 'Combattant', 'Il peut être soldat ou mercenaire, champion de justice, bagarreur de taverne ou détrousseur des rues sombres, etc.'."\n".'Il se spécialise dans les armes de contact.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain2);
        $this->fixtureObject($repo, 6, $book2, 'Commerçant', 'Marchand ambulant ou tenancier d\'une échoppe bien achalandée, le commerçant peut négocier bien des marchandises.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain11);
        $this->fixtureObject($repo, 7, $book2, 'Demorthèn', 'Représentant de la nature, il peut entrer en contact avec les esprits et leur demander d\'accomplir des tâches particulières.'."\n".'Il est le gardien des anciennes traditions péninsulaires et il est souvent considéré avec respect.'."\n".'Les apprentis Demorthèn sont appelés Ionnthèn.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain6);
        $this->fixtureObject($repo, 8, $book2, 'Érudit', 'Passionnés par le savoir, les recherches, les érudits sont souvent employés comme scribes, professeurs ou bibliothécaires.'."\n".'Généralement, un érudit possède un domaine de connaissance de prédilection, comme la théologie, magience, science, etc.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain16);
        $this->fixtureObject($repo, 9, $book2, 'Espion', 'N\'importe qui, qu\'il soit un conseiller haut placé ou un simple mendiant, peut jouer un double rôle, amassant des informations pour le compte d\'un commanditaire.'."\n".'Le domaine secondaire peut être choisi librement pour coller à la fausse identité de l\'espion.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain8);
        $this->fixtureObject($repo, 10, $book2, 'Explorateur', 'Aventurier et casse-cou, l\'explorateur est passionné par le voyage, fuyant souvent la pauvreté ou la monotonie de son lieu de naissance.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain10);
        $this->fixtureObject($repo, 11, $book2, 'Investigateur', 'Habitant généralement dans les grandes villes, les investigateurs proposent leurs services pour mener l\'enquête.'."\n".'Chaque investigateur a son style : certains sont versés dans l\'occultisme, d\'autres dans la science, la magience ou encore la médecine.'."\n".'De ce fait, le choix du domaine secondaire est libre.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain8);
        $this->fixtureObject($repo, 12, $book2, 'Magientiste', 'En Tri-Kazel, on les nomme souvent par le terme dédaigneux de "Daedemorthys".'."\n".'Malgré cette mauvaise réputation, leur science a pour but général l\'amélioration des conditions de vie de l\'humanité.'."\n".'Un magientiste diplômé est un scientör, alors qu\'un élève en cours de formation est un inceptus.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain4);
        $this->fixtureObject($repo, 13, $book2, 'Malandrin', 'Voleur, cambrioleur, tire-laine ; les moyens illégaux pour gagner sa vie sont assez nombreux pour attirer du monde, et ce malgré les risques.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain3);
        $this->fixtureObject($repo, 14, $book2, 'Médecin', 'Il est des endroits où le demorthèn local n\'est pas le meilleur guérisseur.'."\n".'De nouvelles techniques tout-à-fait efficaces proviennent désormais des universités des grandes villes.'."\n".'Certains médecins, les aliénistes, s\'attachent à soigner les troubles psychiques en se référant aux travaux du professeur continental Ernst Zigger.'."\n".'D\'autres, comme les apothicaires, sont spécialisés dans l\'herboristerie.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain13);
        $this->fixtureObject($repo, 15, $book2, 'Occultiste', 'Passionnés d\'ésotérisme, les occultistes sont souvent des universitaires ayant un grand intérêt pour ce domaine dénigré par les autres branches de la science.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain7);
        $this->fixtureObject($repo, 16, $book2, 'Paysan', 'Qu\'il cultive la terre ou élève des animaux, il participe à la vie de la communauté en la nourrissant.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain5);
        $this->fixtureObject($repo, 18, $book2, 'Varigal', 'Voyageur, messager, porteur de nouvelles mais aussi de colis, le varigal est un lien entre les communautés éparses de Tri-Kazel.'."\n".'Passant l\'essentiel de sa vie sur les chemins, il est généralement bien accueilli quand il arrive dans un village.'."\n".'Proches de la nature, les varigaux sont souvent les alliés des demorthèn.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain15);
        $this->fixtureObject($repo, 19, $book13, 'Joueur professionnel', ' Au-delà des jeux de stratégie pratiqués dans les cours et les seigneuries, il existe dans les villes une population de joueurs d\'élite qui ont appris et développé des stratégies.'."\n".'Même quand les règles d’un jeu paraissent simples et le résultat dépendre de la chance ou de l’intuition, le joueur initié sait qu’il n’en est rien.'."\n".'Lui connaît les probabilités et les mathématiques, de sorte qu’il sache précisément ce qu’il risque, ou comment tromper habilement un naïf, au point de pouvoir devenir joueur professionnel et ainsi gagner des sommes considérables au jeu.'."\n".'Il ne s\'agit pas simplement de piécettes, mais bien d\'obtenir de plus puissants qu\'ils soient prêts à parier leur maison ou la main de leur fille, ou n\'importe quel "bien" de valeur d\'ailleurs.'."\n".'L\'astuce remplace la force du guerrier pour monter dans la société et se faire une place au soleil.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain12);
        $this->fixtureObject($repo, 20, $book2, 'Moine du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 21, $book2, 'Clerc du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 22, $book2, 'Prêtre du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 23, $book2, 'Vecteur du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 24, $book2, 'Sigire du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 25, $book2, 'Chevalier lame du Temple', '', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain9);
        $this->fixtureObject($repo, 26, $book13, 'Dàmàthair', 'Les Dàmàthair sont exclusivement des femmes.<br />'."\n".'Elles éduquent et protègent les plus jeunes. Elles assistent aux accouchements, enseignent aux enfants suivant leur âge et les protègent en cas de danger.<br />'."\n".'Le rôle de la Dàmàthair est de créer les liens de la communauté passée, actuelle et future. Les enfants sont élevés ensemble comme une seule et même famille, quelle que soit leur différence de sang afin de plus tard ne former qu\'un seul rempart contre ce qui peut se trouver à l\'extérieur.<br />'."\n".'Si les habitants de Tri-Kazel ont une capacité d\'entraide si importante (surtout dans les montagnes) c\'est parce qu\'on leur enseigne qu\'ils ne sont qu\'une seule entité qui ne peut survivre qu\'en vivant ensemble.<br /><br />'."\n".'La damathair principale d\'une communauté est très attachée à celle-ci et ne la quittera que pour cas de force majeure. Mais il arrive qu\'elle ait une ou plusieurs jeunes assistantes qui n\'ont pas encore fixé leur vocation définitive et peuvent se tourner vers un autre métier. Inversement, il arrive qu\'une varigale, une vectrice (en Gwidre) ou même une militaire choisisse de s\'établir comme damathair. Ces changements de trajectoire sont à discuter entre le joueur et le MJ, du moment qu\'ils respectent la cohérence du personnage.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain11);
        $this->fixtureObject($repo, 27, $book2, 'Combattant à distance', 'Il peut être soldat ou mercenaire, champion de justice, bagarreur de taverne ou détrousseur des rues sombres, etc.'."\n".'Il se spécialise dans les armes à distance', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null, $domain14);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $book, $name, $description, $created, $updated, $deleted = null, $domainPrimary)
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
            $obj = new Jobs();
            $obj->setId($id)
                ->setName($name)
                ->setBook($book)
                ->setDomainPrimary($domainPrimary)
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
            $this->addReference('corahnrin-job-'.$id, $obj);
        }
    }
}