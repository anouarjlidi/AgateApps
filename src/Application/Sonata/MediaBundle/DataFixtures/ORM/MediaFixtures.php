<?php

namespace Application\Sonata\MediaBundle\DataFixtures\ORM;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Sonata\MediaBundle\Document\MediaManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MediaFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var MediaManager
     */
    private $mediaManager;

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
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {

        $this->manager      = $this->container->get('sonata.media.manager.media')->getObjectManager();
        $this->mediaManager = $this->container->get('sonata.media.manager.media');

        $repo = $this->manager->getRepository('ApplicationSonataMediaBundle:Media');

        $this->fixtureObject($repo, 5, 'pastille_brune.png', '', 'sonata.media.provider.image', array('filename' => 'pastille_brune.png'), 25, 25, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 6, 'pastille_bleue.png', '', 'sonata.media.provider.image', array('filename' => 'pastille_bleue.png'), 25, 25, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 7, 'pastille2_brune.png', '', 'sonata.media.provider.image', array('filename' => 'pastille2_brune.png'), 25, 26, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 8, 'pastille2_verte.png', '', 'sonata.media.provider.image', array('filename' => 'pastille2_verte.png'), 25, 26, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 9, 'pastille_grise.png', '', 'sonata.media.provider.image', array('filename' => 'pastille_grise.png'), 25, 25, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 10, 'pastille_verte.png', '', 'sonata.media.provider.image', array('filename' => 'pastille_verte.png'), 25, 25, null, 'image/png', null, 'esteren_maps_markers_types');
        $this->fixtureObject($repo, 11, 'pastille2_grise.png', '', 'sonata.media.provider.image', array('filename' => 'pastille2_grise.png'), 25, 26, null, 'image/png', null, 'esteren_maps_markers_types');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $description, $provider_name, $provider_metadata, $width, $height, $length, $content_type, $author_name, $context)
    {
        $obj       = null;
        $newObject = false;
        $addRef    = false;
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
        $file = $this->container->getParameter('kernel.root_dir').'/../web/img/markerstypes/'.$name;
        if (!file_exists($file)) {
            throw new \RuntimeException('File '.$name.' does not exist in the upload dir.');
        }
        if ($newObject === true) {
            $obj = new Media();
            $obj->setId($id);
            $obj->setName($name);
            $obj->setDescription($description);
            $obj->setProviderName($provider_name);
            $obj->setProviderMetadata($provider_metadata);
            $obj->setWidth($width);
            $obj->setHeight($height);
            $obj->setLength($length);
            $obj->setContentType($content_type);
            $obj->setAuthorName($author_name);
            $obj->setContext($context);
            $obj->setBinaryContent($file);
            $obj->setEnabled(true);
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->mediaManager->save($obj, false);

            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('application-media-'.$id, $obj);
        }
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
