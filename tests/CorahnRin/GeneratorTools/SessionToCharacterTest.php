<?php

namespace Tests\CorahnRin\GeneratorTools;

use CorahnRin\GeneratorTools\SessionToCharacter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SessionToCharacterTest extends KernelTestCase
{
    public static function setUpBeforeClass()
    {
        static::bootKernel();
    }

    public static function tearDownAfterClass()
    {
        static::ensureKernelShutdown();
    }

    public function testCreateCharacterFromGeneratorValues()
    {
    }

    public static function getCharacterFromValues(array $values)
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
