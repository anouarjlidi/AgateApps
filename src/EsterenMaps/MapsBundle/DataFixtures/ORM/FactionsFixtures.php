<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Books;
use EsterenMaps\MapsBundle\Entity\Factions;
use Orbitale\Component\DoctrineTools\AbstractFixture;

class FactionsFixtures extends AbstractFixture
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return Factions::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix()
    {
        return 'esterenmaps-factions';
    }

    /**
     * @return array
     */
    public function getObjects()
    {
        /** @var Books $book2 */
        $book2 = $this->getReference('corahnrin-book-2');

        return [
            [
                'id'          => '1',
                'book'        => $book2,
                'name'        => 'Temple',
                'description' => 'Les adeptes de la religion de l\'Unique.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '2',
                'book'        => $book2,
                'name'        => 'Magience',
                'description' => 'Les partisans d\'une société régie par des principes académiques & scientifiques.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '3',
                'book'        => $book2,
                'name'        => 'Demorthèn',
                'description' => 'Les populations honorant les cultes et traditions ancestrales de Tri-Kazel. ',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '4',
                'book'        => $book2,
                'name'        => 'Neutre',
                'description' => 'Aucun des grands courants idéologiques ne dominent ce lieu.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '5',
                'book'        => $book2,
                'name'        => 'Osags',
                'description' => 'Rattachés au culte demorthèn, les Osags en sont peut-être l\'expression la plus radicale.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '6',
                'book'        => $book2,
                'name'        => 'Tarish',
                'description' => 'Peuple nomade par excellence, ses communautés sont en mouvement constant.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '9',
                'book'        => $book2,
                'name'        => 'Noblesse',
                'description' => 'La noblesse défend des valeurs de tradition, hiérarchie, autorité. Certains nobles sont très dévoués à leur souverain, d\'autres estiment qu\'ils sont seuls maîtres sur leurs terres.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '10',
                'book'        => $book2,
                'name'        => 'Marchand',
                'description' => 'Les marchands sont essentiellement pragmatiques : partisans de la circulation des biens et des personnes, et de législations qui leur permettent de s\'enrichir. Ils peuvent s\'accommoder d\'un peu de corruption, mais veulent des routes sûres.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '11',
                'book'        => $book2,
                'name'        => 'Mixte',
                'description' => 'Plusieurs courants se partagent ou se disputent les lieux sans qu\'il soit véritablement possible de discerner la domination de l\'un d\'eux.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '12',
                'book'        => $book2,
                'name'        => 'Rebelles & Criminels',
                'description' => 'Les individus qui dominent sont en rupture avec la société, pour des raisons d\'intérêt ou d\'opinion. Le territoire est une zone grise, où la violence est endémique.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '13',
                'book'        => $book2,
                'name'        => 'Chevaliers Ronces',
                'description' => 'Les Ronces sont un ordre très ancien dont les activités sont partagées entre la lutte contre les feondas et la gestion d\'organismes bancaires.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:22'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '14',
                'book'        => $book2,
                'name'        => 'Chevaliers Hilderins',
                'description' => 'Cet ordre de chevalerie, très lié à la couronne talkéride, est voué à la lutte contre les feondas et peu à l\'occasion assurer la régence d\'un domaine.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
            [
                'id'          => '15',
                'book'        => $book2,
                'name'        => 'Varigaux',
                'description' => 'Ces guides et messagers arpentent les chemins de la péninsule, assurant le lien entre les communautés les plus isolées. Ils connaissent souvent des raccourcis.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'deletedAt'   => null,
            ],
        ];
    }
}
