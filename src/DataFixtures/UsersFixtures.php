<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataFixtures;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use User\Entity\User;
use User\Util\CanonicalizerTrait;

final class UsersFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface, ORMFixtureInterface
{
    use CanonicalizerTrait;

    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var PasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * Get the order of this fixture.
     */
    public function getOrder(): int
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
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        /** @var EntityRepository $repo */
        $repo = $this->manager->getRepository(User::class);

        $this->passwordEncoder = $this->container->get('security.password_encoder');

        $this->fixtureObject($repo, 1, 'Pierstoval', 'pierstoval@gmail.com', 'admin', true);

        $this->manager->flush();

        $manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $name, $email, $password, $superAdmin)
    {
        $user = null;
        $newObject = false;
        $addRef = false;

        if ($id) {
            $user = $repo->find($id);
            if ($user) {
                $addRef = true;
            } else {
                $newObject = true;
            }
        } else {
            $newObject = true;
        }

        if (true === $newObject) {
            $user = new User();

            $user->setId($id);
            $user->setUsername($name);
            $user->setEmail($email);
            $user->setPlainPassword($password ?: $email);
            $user->setSuperAdmin($superAdmin);
            $user->setEmailCanonical($this->canonicalize($user->getEmail()));
            $user->setUsernameCanonical($this->canonicalize($user->getUsername()));
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->setEmailConfirmed(true);

            if ($id) {
                /** @var ClassMetadataInfo $metadata */
                $metadata = $this->manager->getClassMetadata(\get_class($user));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }

            $this->manager->persist($user);
            $addRef = true;
        }
        if (true === $addRef && $user) {
            $this->addReference('corahnrin-user-'.$id, $user);
        }
    }
}
