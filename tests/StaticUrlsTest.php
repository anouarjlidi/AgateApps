<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebTestCase as PiersTestCase;

class StaticUrlsTest extends WebTestCase
{
    use PiersTestCase;

    /**
     * @dataProvider provideTestUrls
     */
    public function testUrls(
        string $domainName,
        string $url,
        ?string $expectedRouteName,
        int $expectedStatusCode = 200,
        string $expectedRedirectUrlOrTitleContent = '',
        string $cssSelectorToCheck = '#content h1'
    ) {
        $client = $this->getClient($domainName);

        $crawler = $client->request('GET', $url);

        /** @var Request $req */
        $req = $client->getRequest();

        /** @var Response $res */
        $res = $client->getResponse();

        $this->assertSame($expectedRouteName, $req->attributes->get('_route'), 'Unexpected route name.');
        $this->assertSame($expectedStatusCode, $res->getStatusCode(), 'Unexpected status code.');

        if ($expectedRedirectUrlOrTitleContent) {
            /** @see \Symfony\Component\HttpFoundation\Response::isRedirect() */
            if (\in_array($expectedStatusCode, [201, 301, 302, 303, 307, 308], true)) {
                $message = sprintf(
                    'Unexpected redirect url. Expected "%s", got "%s".',
                    $expectedRedirectUrlOrTitleContent, $res->headers->get('Location')
                );
                $this->assertTrue($res->isRedirect($expectedRedirectUrlOrTitleContent), $message);
            } else {
                $title = $crawler->filter($cssSelectorToCheck);
                $this->assertNotNull($title, 'No node found for the CSS selector.');
                $this->assertSame($expectedRedirectUrlOrTitleContent, trim($title->text()));
            }
        }
    }

    public function provideTestUrls()
    {
        // Root tests for all domains
        yield 0 => ['www.studio-agate.docker', '/', 'root', 301, '/fr/'];
        yield 1 => ['www.studio-agate.docker', '/fr', 'root', 301, '/fr/'];
        yield 2 => ['www.studio-agate.docker', '/en', 'root', 301, '/en/'];
        yield 3 => ['www.vermine2047.docker', '/', 'root', 301, '/fr/'];
        yield 4 => ['www.vermine2047.docker', '/fr', 'root', 301, '/fr/'];
        yield 5 => ['www.vermine2047.docker', '/en', 'root', 301, '/en/'];
        yield 6 => ['www.dragons-rpg.docker', '/', 'root', 301, '/fr/'];
        yield 7 => ['www.dragons-rpg.docker', '/fr', 'root', 301, '/fr/'];
        yield 8 => ['www.dragons-rpg.docker', '/en', 'root', 301, '/en/'];
        yield 9 => ['corahnrin.esteren.docker', '/', 'root', 301, '/fr/'];
        yield 10 => ['corahnrin.esteren.docker', '/fr', 'root', 301, '/fr/'];
        yield 11 => ['corahnrin.esteren.docker', '/en', 'root', 301, '/en/'];
        yield 12 => ['maps.esteren.docker', '/', 'root', 301, '/fr/'];
        yield 13 => ['maps.esteren.docker', '/fr', 'root', 301, '/fr/'];
        yield 14 => ['maps.esteren.docker', '/en', 'root', 301, '/en/'];
        yield 15 => ['portal.esteren.docker', '/', 'root', 301, '/fr/'];
        yield 16 => ['portal.esteren.docker', '/fr', 'root', 301, '/fr/'];
        yield 17 => ['portal.esteren.docker', '/en', 'root', 301, '/en/'];

        // Studio Agate
        yield 18 => ['www.studio-agate.docker', '/fr/', 'agate_portal_home', 200, 'Bienvenue sur le nouveau portail du Studio Agate'];
        yield 19 => ['www.studio-agate.docker', '/en/', 'agate_portal_home', 200, 'Welcome to the new Studio Agate portal'];
        yield 20 => ['www.studio-agate.docker', '/fr/team', 'agate_team', 200, 'L\'Équipe du studio Agate'];
        yield 21 => ['www.studio-agate.docker', '/en/team', 'agate_team', 200, 'The Studio Agate team'];
        yield 22 => ['www.studio-agate.docker', '/fr/legal', 'legal_mentions', 200, 'Mentions légales', '#content h2'];
        yield 23 => ['www.studio-agate.docker', '/en/legal', 'legal_mentions', 404];

        // Vermine portal
        yield 24 => ['www.vermine2047.docker', '/fr/', 'vermine_portal_home', 200, 'Vermine 2047', 'title'];
        yield 25 => ['www.vermine2047.docker', '/en/', 'vermine_portal_home', 200, 'Vermine 2047', 'title'];

        // Esteren portal
        yield 26 => ['portal.esteren.docker', '/fr/', 'esteren_portal_home', 200, 'Bienvenue sur le nouveau portail des Ombres d\'Esteren'];
        yield 27 => ['portal.esteren.docker', '/en/', 'esteren_portal_home', 200, 'Welcome to the new Shadows of Esteren\'s portal!'];
        yield 28 => ['portal.esteren.docker', '/fr/feond-beer', 'esteren_portal_feond_beer', 200, 'La bière du Féond', 'title'];
        yield 29 => ['portal.esteren.docker', '/en/feond-beer', 'esteren_portal_feond_beer', 200, 'La bière du Féond', 'title'];

        // Corahn-Rin
        yield 30 => ['corahnrin.esteren.docker', '/fr/', 'corahn_rin_home', 200, 'Corahn-Rin, le générateur de personnage pour Les Ombres d\'Esteren', 'title'];
        yield 31 => ['corahnrin.esteren.docker', '/en/', 'corahn_rin_home', 200, 'Corahn-Rin, the character manager for Shadows of Esteren', 'title'];

        // Dragons
        yield 32 => ['www.dragons-rpg.docker', '/fr/', 'dragons_home', 200, 'Bienvenue sur le nouveau portail du jeu de rôle Dragons'];
        yield 33 => ['www.dragons-rpg.docker', '/en/', 'dragons_home', 200, 'Welcome to Dragons RPG portal'];
    }
}
