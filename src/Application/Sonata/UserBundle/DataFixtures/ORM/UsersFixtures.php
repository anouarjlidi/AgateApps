<?php

namespace Application\Sonata\UserBundle\DataFixtures\ORM;

use Application\Sonata\UserBundle\Entity\User;
use Sonata\UserBundle\Entity\UserManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        /** @var EntityRepository $repo */
        $repo = $this->manager->getRepository('ApplicationSonataUserBundle:User');

        $this->userManager = $this->container->get('fos_user.user_manager');

        $this->fixtureObject($repo, 1, 'Pierstoval', 'pierstoval@gmail.com', 'admin', true);

        $this->manager->flush();

        $manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $email, $password, $superAdmin)
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
            /** @var User $obj */
            $obj = $this->userManager->createUser();
            if (!($obj instanceof User)) {
                throw new \RuntimeException('Error : User class should be "'.User::class.'", got "'.get_class($obj).'" instead.');
            }
            $obj
                ->setId($id)
                ->setUsername($name)
                ->setEmail($email)
                ->setPlainPassword($password ?: $email)
                ->setSuperAdmin($superAdmin)
                ->setEnabled(true)
            ;

            if ($id) {
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-user-'.$id, $obj);
        }
    }
}