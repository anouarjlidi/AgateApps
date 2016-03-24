<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\SocialClasses;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class SocialClassesFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinBundle:SocialClasses');

        $domain1 = $this->getReference('corahnrin-domain-1');
        $domain2 = $this->getReference('corahnrin-domain-2');
//        $domain3 = $this->getReference('corahnrin-domain-3');
//        $domain4 = $this->getReference('corahnrin-domain-4');
        $domain5 = $this->getReference('corahnrin-domain-5');
//        $domain6 = $this->getReference('corahnrin-domain-6');
//        $domain7 = $this->getReference('corahnrin-domain-7');
        $domain8 = $this->getReference('corahnrin-domain-8');
        $domain9 = $this->getReference('corahnrin-domain-9');
        $domain10 = $this->getReference('corahnrin-domain-10');
        $domain11 = $this->getReference('corahnrin-domain-11');
        $domain12 = $this->getReference('corahnrin-domain-12');
        $domain13 = $this->getReference('corahnrin-domain-13');
//        $domain14 = $this->getReference('corahnrin-domain-14');
        $domain15 = $this->getReference('corahnrin-domain-15');
        $domain16 = $this->getReference('corahnrin-domain-16');

        $this->fixtureObject($repo, 1, array($domain5, $domain8, $domain10, $domain15), 'Paysan', 'Les roturiers font partie de la majorité de la population. Vous avez vécu dans une famille paysanne, à l\'écart des villes et cités, sans pour autant les ignorer. Vous êtes plus proche de la nature.'."\n".'les Demorthèn font également partie de cette classe sociale.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 2, array($domain1, $domain11, $domain13, $domain16), 'Artisan', 'Les roturiers font partie de la majorité de la population. Votre famille était composée d\'un ou plusieurs artisans ou ouvriers, participant à la vie communale et familiale usant de ses talents manuels.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 3, array($domain1, $domain11, $domain12, $domain16), 'Bourgeois', 'Votre famille a su faire des affaires dans les villes, ou tient probablement un commerce célèbre dans votre région, ce qui vous permet de vivre confortablement au sein d\'une communauté familière.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 4, array($domain9, $domain11, $domain15, $domain16), 'Clergé', 'Votre famille a toujours respecté l\'Unique et ses représentants, et vous êtes issu d\'un milieu très pieux.'."\n".'Vous avez probablement la foi, vous aussi.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);
        $this->fixtureObject($repo, 5, array($domain2, $domain11, $domain13, $domain16), 'Noblesse', 'Vous portez peut-être un grand nom des affaires des grandes cités, ou avez grandi en ville. Néanmoins, votre famille est placée assez haut dans la noblesse pour vous permettre d\'avoir eu des enseignements particuliers.', '2014-04-09 08:56:43', '2014-04-09 08:56:43', null);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $domains, $name, $description, $created, $updated, $deleted = null)
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
            $obj = new SocialClasses();
            $obj->setId($id)
                ->setName($name)
                ->setDescription($description)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            foreach ($domains as $domain) {
                $obj->addDomain($domain);
            }
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-social-class-'.$id, $obj);
        }
    }
}
