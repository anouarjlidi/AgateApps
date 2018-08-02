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

use CorahnRin\Data\Domains;
use CorahnRin\Entity\Jobs;
use DataFixtures\FixtureMetadataIdGeneratorTrait;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Orbitale\Component\DoctrineTools\AbstractFixture;

class JobsFixtures extends AbstractFixture implements ORMFixtureInterface
{
    use FixtureMetadataIdGeneratorTrait;

    /**
     * Returns the class of the entity you're managing.
     */
    protected function getEntityClass(): string
    {
        return Jobs::class;
    }

    /**
     * Get the order of this fixture.
     */
    public function getOrder(): int
    {
        return 4;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects()
    {
        $book2 = $this->getReference('corahnrin-book-2');
        $book13 = $this->getReference('corahnrin-book-13');

        return [
            [
                'id' => 1,
                'name' => 'Artisan',
                'description' => 'Quel que soit son domaine, l\'artisan est un manuel qualifié.
Forgeron, cuisinier, architecte, cordonnier, bûcheron, sculpteur, joailler ; les artisans couvrent un grand nombre de spécialités.
Dans les cités où est implantée la magience, on trouve aussi des réparateurs d\'artefacts et des ouvriers spécialisés travaillant dans les usines.',
                'primaryDomain' => Domains::CRAFT['title'],
                'dailySalary' => 8,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::SCIENCE['title'],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Barde',
                'description' => 'Le statut de barde est hautement honorifique et les plus puissants monarques s\'entourent de ces artistes qui ont de véritables rôles d\'éminence grise.
Artiste, acrobate, musicien, bouffon, le barde peut revêtir différents rôles.
Il peut également être connu sous d\'autres noms, comme les poètes aveugles filidh ou les étranges céilli de l\'archipel des Tri-Sweszörs.',
                'primaryDomain' => Domains::PERFORMANCE['title'],
                'dailySalary' => 10,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::TRAVEL['title'],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Chasseur',
                'description' => 'Il nourrit la communauté du produit de ses longues expéditions, qui durent parfois plusieurs jours.
L\'expansion des villes a vu l\'apparition de chasseurs d\'un genre nouveau comme les ratiers.
D\'autres, comme les Enfants de Neven, dédient leur existence à la traque des feondas.',
                'primaryDomain' => Domains::NATURAL_ENVIRONMENT['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CLOSE_COMBAT['title'],
                    Domains::SHOOTING_AND_THROWING['title'],
                ],
            ],
            [
                'id' => 4,
                'name' => 'Chevalier',
                'description' => 'Ces hommes et ces femmes font partie de la noblesse et appartiennent le plus souvent à un ordre de chevalerie comme les Hilderins ou les Ronces.
Certains sont des chevaliers errants, derniers héritiers d\'une famille noble ; d\'autres, les vassaux d\'un puissant seigneur.',
                'primaryDomain' => Domains::CLOSE_COMBAT['title'],
                'dailySalary' => 10,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::TRAVEL['title'],
                ],
            ],
            [
                'id' => 5,
                'name' => 'Combattant',
                'description' => 'Il peut être soldat ou mercenaire, champion de justice, bagarreur de taverne ou détrousseur des rues sombres, etc.
Il se spécialise dans les armes de contact.',
                'primaryDomain' => Domains::CLOSE_COMBAT['title'],
                'dailySalary' => 7,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::FEATS['title'],
                    Domains::SHOOTING_AND_THROWING['title'],
                ],
            ],
            [
                'id' => 6,
                'name' => 'Commerçant',
                'description' => 'Marchand ambulant ou tenancier d\'une échoppe bien achalandée, le commerçant peut négocier bien des marchandises.',
                'primaryDomain' => Domains::RELATION['title'],
                'dailySalary' => 8,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CRAFT['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 7,
                'name' => 'Demorthèn',
                'description' => 'Représentant de la nature, il peut entrer en contact avec les esprits et leur demander d\'accomplir des tâches particulières.
Il est le gardien des anciennes traditions péninsulaires et il est souvent considéré avec respect.
Les apprentis Demorthèn sont appelés Ionnthèn.',
                'primaryDomain' => Domains::DEMORTHEN_MYSTERIES['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::NATURAL_ENVIRONMENT['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 8,
                'name' => 'Érudit',
                'description' => 'Passionnés par le savoir, les recherches, les érudits sont souvent employés comme scribes, professeurs ou bibliothécaires.
Généralement, un érudit possède un domaine de connaissance de prédilection, comme la théologie, magience, science, etc.',
                'primaryDomain' => Domains::ERUDITION['title'],
                'dailySalary' => 8,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::SCIENCE['title'],
                    Domains::OCCULTISM['title'],
                ],
            ],
            [
                'id' => 9,
                'name' => 'Espion',
                'description' => 'N\'importe qui, qu\'il soit un conseiller haut placé ou un simple mendiant, peut jouer un double rôle, amassant des informations pour le compte d\'un commanditaire.
Le domaine secondaire peut être choisi librement pour coller à la fausse identité de l\'espion.',
                'primaryDomain' => Domains::PERCEPTION['title'],
                'dailySalary' => 9,
                'book' => $book2,
                'secondaryDomains' => [],
            ],
            [
                'id' => 10,
                'name' => 'Explorateur',
                'description' => 'Aventurier et casse-cou, l\'explorateur est passionné par le voyage, fuyant souvent la pauvreté ou la monotonie de son lieu de naissance.',
                'primaryDomain' => Domains::FEATS['title'],
                'dailySalary' => 9,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::NATURAL_ENVIRONMENT['title'],
                    Domains::TRAVEL['title'],
                ],
            ],
            [
                'id' => 11,
                'name' => 'Investigateur',
                'description' => 'Habitant généralement dans les grandes villes, les investigateurs proposent leurs services pour mener l\'enquête.
Chaque investigateur a son style : certains sont versés dans l\'occultisme, d\'autres dans la science, la magience ou encore la médecine.
De ce fait, le choix du domaine secondaire est libre.',
                'primaryDomain' => Domains::PERCEPTION['title'],
                'dailySalary' => 9,
                'book' => $book2,
                'secondaryDomains' => [],
            ],
            [
                'id' => 12,
                'name' => 'Magientiste',
                'description' => 'En Tri-Kazel, on les nomme souvent par le terme dédaigneux de "Daedemorthys".
Malgré cette mauvaise réputation, leur science a pour but général l\'amélioration des conditions de vie de l\'humanité.
Un magientiste diplômé est un scientör, alors qu\'un élève en cours de formation est un inceptus.',
                'primaryDomain' => Domains::MAGIENCE['title'],
                'dailySalary' => 10,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::SCIENCE['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 13,
                'name' => 'Malandrin',
                'description' => 'Voleur, cambrioleur, tire-laine ; les moyens illégaux pour gagner sa vie sont assez nombreux pour attirer du monde, et ce malgré les risques.',
                'primaryDomain' => Domains::STEALTH['title'],
                'dailySalary' => 8,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::FEATS['title'],
                    Domains::PERFORMANCE['title'],
                ],
            ],
            [
                'id' => 14,
                'name' => 'Médecin',
                'description' => 'Il est des endroits où le demorthèn local n\'est pas le meilleur guérisseur.
De nouvelles techniques tout-à-fait efficaces proviennent désormais des universités des grandes villes.
Certains médecins, les aliénistes, s\'attachent à soigner les troubles psychiques en se référant aux travaux du professeur continental Ernst Zigger.
D\'autres, comme les apothicaires, sont spécialisés dans l\'herboristerie.',
                'primaryDomain' => Domains::SCIENCE['title'],
                'dailySalary' => 10,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 15,
                'name' => 'Occultiste',
                'description' => 'Passionnés d\'ésotérisme, les occultistes sont souvent des universitaires ayant un grand intérêt pour ce domaine dénigré par les autres branches de la science.',
                'primaryDomain' => Domains::OCCULTISM['title'],
                'dailySalary' => 8,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::SCIENCE['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 16,
                'name' => 'Paysan',
                'description' => 'Qu\'il cultive la terre ou élève des animaux, il participe à la vie de la communauté en la nourrissant.',
                'primaryDomain' => Domains::NATURAL_ENVIRONMENT['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CRAFT['title'],
                    Domains::FEATS['title'],
                ],
            ],
            [
                'id' => 18,
                'name' => 'Varigal',
                'description' => 'Voyageur, messager, porteur de nouvelles mais aussi de colis, le varigal est un lien entre les communautés éparses de Tri-Kazel.
Passant l\'essentiel de sa vie sur les chemins, il est généralement bien accueilli quand il arrive dans un village.
Proches de la nature, les varigaux sont souvent les alliés des demorthèn.',
                'primaryDomain' => Domains::TRAVEL['title'],
                'dailySalary' => 10,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::NATURAL_ENVIRONMENT['title'],
                    Domains::FEATS['title'],
                ],
            ],
            [
                'id' => 19,
                'name' => 'Joueur professionnel',
                'description' => ' Au-delà des jeux de stratégie pratiqués dans les cours et les seigneuries, il existe dans les villes une population de joueurs d\'élite qui ont appris et développé des straté
gies.
Même quand les règles d\'un jeu paraissent simples et le résultat dépendre de la chance ou de l\'intuition, le joueur initié sait qu\'il n\'en est rien.
Lui connaît les probabilités et les mathématiques, de sorte qu\'il sache précisément ce qu\'il risque, ou comment tromper habilement un naïf, au point de pouvoir devenir joueur professionnel et ai
nsi gagner des sommes considérables au jeu.
Il ne s\'agit pas simplement de piécettes, mais bien d\'obtenir de plus puissants qu\'ils soient prêts à parier leur maison ou la main de leur fille, ou n\'importe quel "bien" de valeur d\'ailleurs.
L\'astuce remplace la force du guerrier pour monter dans la société et se faire une place au soleil.',
                'primaryDomain' => Domains::PERFORMANCE['title'],
                'dailySalary' => 12,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                ],
            ],
            [
                'id' => 20,
                'name' => 'Moine du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CRAFT['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 21,
                'name' => 'Clerc du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 22,
                'name' => 'Prêtre du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 23,
                'name' => 'Vecteur du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::RELATION['title'],
                    Domains::TRAVEL['title'],
                ],
            ],
            [
                'id' => 24,
                'name' => 'Sigire du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CLOSE_COMBAT['title'],
                ],
            ],
            [
                'id' => 25,
                'name' => 'Chevalier lame du Temple',
                'description' => '',
                'primaryDomain' => Domains::PRAYER['title'],
                'dailySalary' => 6,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CLOSE_COMBAT['title'],
                ],
            ],
            [
                'id' => 26,
                'name' => 'Dàmàthair',
                'description' => 'Les Dàmàthair sont exclusivement des femmes.
Elles éduquent et protègent les plus jeunes. Elles assistent aux accouchements, enseignent aux enfants suivant leur âge et les protègent en cas de danger.
Le rôle de la Dàmàthair est de créer les liens de la communauté passée, actuelle et future. Les enfants sont élevés ensemble comme une seule et même famille, quelle que soit leur différence de s
ang afin de plus tard ne former qu\'un seul rempart contre ce qui peut se trouver à l\'extérieur.
Si les habitants de Tri-Kazel ont une capacité d\'entraide si importante (surtout dans les montagnes) c\'est parce qu\'on leur enseigne qu\'ils ne sont qu\'une seule entité qui ne peut survivre qu\'en vivant ensemble.
La damathair principale d\'une communauté est très attachée à celle-ci et ne la quittera que pour cas de force majeure. Mais il arrive qu\'elle ait une ou plusieurs jeunes assistantes qui n\'ont pas encore fixé leur vocation définitive et peuvent se tourner vers un autre métier. Inversement, il arrive qu\'une varigale, une vectrice (en Gwidre) ou même une militaire choisisse de s\'établir comme damathair. Ces changements de trajectoire sont à discuter entre le joueur et le MJ, du moment qu\'ils respectent la cohérence du personnage.',
                'primaryDomain' => Domains::RELATION['title'],
                'dailySalary' => 6,
                'book' => $book13,
                'secondaryDomains' => [
                    Domains::CLOSE_COMBAT['title'],
                    Domains::ERUDITION['title'],
                ],
            ],
            [
                'id' => 27,
                'name' => 'Combattant à distance',
                'description' => 'Il peut être soldat ou mercenaire, champion de justice, bagarreur de taverne ou détrousseur des rues sombres, etc.
Il se spécialise dans les armes à distance',
                'primaryDomain' => Domains::SHOOTING_AND_THROWING['title'],
                'dailySalary' => 7,
                'book' => $book2,
                'secondaryDomains' => [
                    Domains::CLOSE_COMBAT['title'],
                    Domains::FEATS['title'],
                ],
            ],
        ];
    }
}
