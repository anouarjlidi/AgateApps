<?php

namespace Esteren\PortalBundle\Tests;

use Doctrine\ORM\EntityManager;
use Esteren\PortalBundle\Entity\Page;
use Tests\WebTestCase;

class PortalControllerTest extends WebTestCase
{
    public function testIndexWithHomepage()
    {
        static::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        // Find first page
        $page = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('EsterenPortalBundle:Page')
            ->findOneBy([
                'homepage' => true,
                'enabled' => true,
            ])
        ;

        $client->restart();

        $crawler = $client->request('GET', '/fr/');
        static::assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        static::assertEquals($page->getTitle(), trim($crawler->filter('#content h1')->html()));
        static::assertContains($page->getContent(), trim($crawler->filter('#content')->html()));
    }

    /**
     * @see GeneratorController::indexAction
     */
    public function testIndexWithOnePage()
    {
        static::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $page = new Page();
        $page
            ->setTemplate('base.html.twig')
            ->setHost('portal.esteren.dev')
            ->setTitle('Page test')
            ->setContent('<h2>This tag is only here for testing</h2>')
            ->setSlug('page-test')
            ->setLocale('fr')
        ;

        /** @var EntityManager $em */
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $em->persist($page);
        $em->flush();

        // First, we check that "enabled" is false by default
        $client->request('GET', '/fr/page-test');
        static::assertEquals(404, $client->getResponse()->getStatusCode());

        $page->setEnabled(true);
        $em->flush($page);

        $client->restart();

        $crawler = $client->request('GET', '/fr/page-test');
        static::assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());

        static::assertEquals($page->getTitle(), trim($crawler->filter('#content h1')->html()));
        static::assertContains($page->getContent(), trim($crawler->filter('#content')->html()));
    }

}
