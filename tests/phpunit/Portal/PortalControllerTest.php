<?php

namespace Tests\Portal;

use Orbitale\Bundle\CmsBundle\Entity\Page;
use Tests\WebTestCase;

class PortalControllerTest extends WebTestCase
{
    /**
     * @see GeneratorController::indexAction
     */
    public function testIndexWithNoPage()
    {
        $client = static::getClient('portal.esteren.dev');

        $client->request('GET', '/fr/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @see GeneratorController::indexAction
     */
    public function testIndexWithOneHomePage()
    {
        $client = static::getClient('portal.esteren.dev');

        $page = new Page();
        $page
            ->setHomepage(true)
            ->setHost('portal.esteren.dev')
            ->setTitle('Page test')
            ->setContent('<h2>This tag is only here for testing</h2>')
            ->setSlug('page-test')
            ->setLocale('fr')
        ;

        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $em->persist($page);
        $em->flush();

        $crawler = $client->request('GET', '/fr/page-test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals($page->getTitle(), trim($crawler->filter('#content section article h1')->html()));
        $this->assertContains($page->getContent(), trim($crawler->filter('#content section article')->html()));
    }

}
