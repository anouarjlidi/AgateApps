<?php

namespace Tests\CorahnRin\GeneratorTools;

use CorahnRin\Entity\Characters;
use CorahnRin\GeneratorTools\SessionToCharacter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class SessionToCharacterTest extends KernelTestCase
{
    /** @var PropertyAccessor */
    private static $propertyAccessor;

    public static function setUpBeforeClass()
    {
        static::bootKernel();
        static::$propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public static function tearDownAfterClass()
    {
        static::ensureKernelShutdown();
        static::$propertyAccessor = null;
    }

    public function test base working character(): void
    {
        // This one is just here as a smoke test,
        // just like the FullValidStepsControllerTest class.
        $character = static::getCharacterFromValues($values = [
            '01_people' => 1,
            '02_job' => 1,
            '03_birthplace' => 1,
            '04_geo' => 1,
            '05_social_class' => [
                'id' => 1,
                'domains' => [
                    0 => 'domains.natural_environment',
                    1 => 'domains.perception',
                ],
            ],
            '06_age' => 31,
            '07_setbacks' => [
                2 => [
                    'id' => 2,
                    'avoided' => false,
                ],
                3 => [
                    'id' => 3,
                    'avoided' => false,
                ],
            ],
            '08_ways' => [
                'ways.combativeness' => 5,
                'ways.creativity' => 4,
                'ways.empathy' => 3,
                'ways.reason' => 2,
                'ways.conviction' => 1,
            ],
            '09_traits' => [
                'quality' => 1,
                'flaw' => 10,
            ],
            '10_orientation' => 'character.orientation.instinctive',
            '11_advantages' => [
                'advantages' => [
                    3 => 1,
                    8 => 1,
                ],
                'disadvantages' => [
                    31 => 1,
                    47 => 1,
                    48 => 1,
                ],
                'advantages_indications' => [
                    3 => 'Influent ally',
                    48 => 'Some phobia',
                ],
                'remainingExp' => 80,
            ],
            '12_mental_disorder' => 1,
            '13_primary_domains' => [
                'domains' => [
                    'domains.craft' => 5,
                    'domains.close_combat' => 2,
                    'domains.stealth' => 1,
                    'domains.magience' => 0,
                    'domains.natural_environment' => 0,
                    'domains.demorthen_mysteries' => 0,
                    'domains.occultism' => 0,
                    'domains.perception' => 0,
                    'domains.prayer' => 0,
                    'domains.feats' => 0,
                    'domains.relation' => 3,
                    'domains.performance' => 0,
                    'domains.science' => 1,
                    'domains.shooting_and_throwing' => 0,
                    'domains.travel' => 0,
                    'domains.erudition' => 2,
                ],
                'ost' => 'domains.close_combat',
            ],
            '14_use_domain_bonuses' => [
                'domains' => [
                    'domains.craft' => 0,
                    'domains.close_combat' => 1,
                    'domains.stealth' => 0,
                    'domains.magience' => 0,
                    'domains.natural_environment' => 0,
                    'domains.demorthen_mysteries' => 0,
                    'domains.occultism' => 0,
                    'domains.perception' => 0,
                    'domains.prayer' => 0,
                    'domains.feats' => 0,
                    'domains.relation' => 0,
                    'domains.performance' => 0,
                    'domains.science' => 0,
                    'domains.shooting_and_throwing' => 0,
                    'domains.travel' => 0,
                    'domains.erudition' => 0,
                ],
                'remaining' => 2,
            ],
            '15_domains_spend_exp' => [
                'domains' => [
                    'domains.craft' => null,
                    'domains.close_combat' => 1,
                    'domains.stealth' => null,
                    'domains.magience' => null,
                    'domains.natural_environment' => 2,
                    'domains.demorthen_mysteries' => null,
                    'domains.occultism' => null,
                    'domains.perception' => null,
                    'domains.prayer' => null,
                    'domains.feats' => null,
                    'domains.relation' => null,
                    'domains.performance' => null,
                    'domains.science' => null,
                    'domains.shooting_and_throwing' => null,
                    'domains.travel' => null,
                    'domains.erudition' => null,
                ],
                'remainingExp' => 50,
            ],
            '16_disciplines' => [
                'disciplines' => [
                    'domains.craft' => [
                        12 => true,
                        45 => true,
                        92 => true,
                    ],
                ],
                'remainingExp' => 25,
                'remainingBonusPoints' => 0,
            ],
            '17_combat_arts' => [
                'combatArts' => [
                    1 => true,
                ],
                'remainingExp' => 5,
            ],
            '18_equipment' => [
                'armors' => [
                    9 => true,
                ],
                'weapons' => [
                    5 => true,
                ],
                'equipment' => [
                    'Livre de règles',
                ],
            ],
            '19_description' => [
                'name' => 'A',
                'player_name' => 'B',
                'sex' => 'character.sex.female',
                'description' => '',
                'story' => '',
                'facts' => '',
            ],
            '20_finish' => true,
        ]);

        static::assertSame($values['01_people'], static::$propertyAccessor->getValue($character, 'people.id'));
        static::assertSame($values['02_job'], static::$propertyAccessor->getValue($character, 'job.id'));
        static::assertSame($values['03_birthplace'], static::$propertyAccessor->getValue($character, 'birthplace.id'));
        static::assertSame($values['04_geo'], static::$propertyAccessor->getValue($character, 'geoLiving.id'));
        static::assertSame($values['05_social_class']['id'], static::$propertyAccessor->getValue($character, 'socialClass.id'));
        static::assertSame($values['05_social_class']['domains'][0], static::$propertyAccessor->getValue($character, 'socialClassDomain1'));
        static::assertSame($values['05_social_class']['domains'][1], static::$propertyAccessor->getValue($character, 'socialClassDomain2'));
        static::assertSame($values['06_age'], static::$propertyAccessor->getValue($character, 'age'));
    }

    public static function getCharacterFromValues(array $values): Characters
    {
        $sut = static::createInstance();

        return $sut->createCharacterFromGeneratorValues($values);
    }

    public static function createInstance(): SessionToCharacter
    {
        if (!static::$kernel) {
            static::bootKernel();
        }

        return static::$kernel
            ->getContainer()
            ->get('test.service_container')
            ->get(SessionToCharacter::class)
        ;
    }
}
