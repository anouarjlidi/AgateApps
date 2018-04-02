<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\DataFixtures\ORM;

use CorahnRin\Entity\Books;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use EsterenMaps\Entity\Factions;
use Orbitale\Component\DoctrineTools\AbstractFixture;
use Agate\Doctrine\FixtureMetadataIdGeneratorTrait;

class FactionsFixtures extends AbstractFixture implements ORMFixtureInterface
{
    use FixtureMetadataIdGeneratorTrait;

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
     * {@inheritdoc}
     */
    protected function getEntityClass(): string
    {
        return Factions::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferencePrefix(): ?string
    {
        return 'esterenmaps-factions-';
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
                'id'          => 1,
                'book'        => $book2,
                'name'        => 'Temple',
                'description' => 'Les adeptes de la religion de l\'Unique.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 2,
                'book'        => $book2,
                'name'        => 'Magience',
                'description' => 'Les partisans d\'une société régie par des principes académiques & scientifiques.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 3,
                'book'        => $book2,
                'name'        => 'Demorthèn',
                'description' => 'Les populations honorant les cultes et traditions ancestrales de Tri-Kazel. ',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-17 22:51:49'),
            ],
            [
                'id'          => 4,
                'book'        => $book2,
                'name'        => 'Neutre',
                'description' => 'Aucun des grands courants idéologiques ne dominent ce lieu.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 5,
                'book'        => $book2,
                'name'        => 'Osags',
                'description' => 'Rattachés au culte demorthèn, les Osags en sont peut-être l\'expression la plus radicale.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 6,
                'book'        => $book2,
                'name'        => 'Tarish',
                'description' => 'Peuple nomade par excellence, ses communautés sont en mouvement constant.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 9,
                'book'        => $book2,
                'name'        => 'Noblesse',
                'description' => 'La noblesse défend des valeurs de tradition, hiérarchie, autorité. Certains nobles sont très dévoués à leur souverain, d\'autres estiment qu\'ils sont seuls maîtres sur leurs terres.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 10,
                'book'        => $book2,
                'name'        => 'Marchand',
                'description' => 'Les marchands sont essentiellement pragmatiques : partisans de la circulation des biens et des personnes, et de législations qui leur permettent de s\'enrichir. Ils peuvent s\'accommoder d\'un peu de corruption, mais veulent des routes sûres.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 11,
                'book'        => $book2,
                'name'        => 'Mixte',
                'description' => 'Plusieurs courants se partagent ou se disputent les lieux sans qu\'il soit véritablement possible de discerner la domination de l\'un d\'eux.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 12,
                'book'        => $book2,
                'name'        => 'Rebelles & Criminels',
                'description' => 'Les individus qui dominent sont en rupture avec la société, pour des raisons d\'intérêt ou d\'opinion. Le territoire est une zone grise, où la violence est endémique.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 13,
                'book'        => $book2,
                'name'        => 'Chevaliers Ronces',
                'description' => 'Les Ronces sont un ordre très ancien dont les activités sont partagées entre la lutte contre les feondas et la gestion d\'organismes bancaires.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:22'),
            ],
            [
                'id'          => 14,
                'book'        => $book2,
                'name'        => 'Chevaliers Hilderins',
                'description' => 'Cet ordre de chevalerie, très lié à la couronne talkéride, est voué à la lutte contre les feondas et peu à l\'occasion assurer la régence d\'un domaine.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
            [
                'id'          => 15,
                'book'        => $book2,
                'name'        => 'Varigaux',
                'description' => 'Ces guides et messagers arpentent les chemins de la péninsule, assurant le lien entre les communautés les plus isolées. Ils connaissent souvent des raccourcis.',
                'createdAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
                'updatedAt'   => \DateTime::createFromFormat('Y-m-d H:i:s', '2015-07-10 20:49:05'),
            ],
        ];
    }
}
