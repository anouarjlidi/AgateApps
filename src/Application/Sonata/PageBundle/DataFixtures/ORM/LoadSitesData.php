<?php

namespace Application\Sonata\PageBundle\DataFixtures\ORM;

use Application\Sonata\PageBundle\Entity\Site;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SiteFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 0;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        /** @var EntityRepository $repo */
        $repo = $this->manager->getRepository('ApplicationSonataPageBundle:Site');

        $container = $this->container;

        // Cette closer récupère plus "joliment" le paramètre nécessaire
        $host = function($param) use ($container) {
            return $container->getParameter('esteren_domains.'.$param);
        };

        $this->fixtureObject($repo, 1, 'Portail Esteren', '/', $host('portal'), true);
        $this->fixtureObject($repo, 2, 'Backoffice Esteren', '/', $host('backoffice'), false);
        $this->fixtureObject($repo, 3, 'Corahn-Rin', '/', $host('corahn_rin'), false);
        $this->fixtureObject($repo, 4, 'Esteren Maps', '/', $host('esteren_maps'), false);
        $this->fixtureObject($repo, 5, 'Esteren API', '/', $host('api'), false);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $relativePath, $host, $isDefault)
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
            $obj = new Site();
            $obj->setId($id);
            $obj->setName($name);
            $obj->setRelativePath($relativePath);
            $obj->setHost($host);
            $obj->setIsDefault((bool) $isDefault);
            $obj->setEnabled(true);
            $obj->setLocale('fr');
            $obj->setTitle('');
            $obj->setMetaDescription('');
            $obj->setMetaKeywords('');
            $obj->setEnabledFrom(null);
            $obj->setEnabledTo(null);
            $obj->setCreatedAt(new \Datetime());
            $obj->setUpdatedAt(null);
            if ($id) {
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-site-'.$id, $obj);
        }
    }
}