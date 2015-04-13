<?php

namespace CorahnRin\CorahnRinBundle\DataFixtures\ORM;

use CorahnRin\CorahnRinBundle\Entity\Avantages;
use CorahnRin\CorahnRinBundle\Entity\Books;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class AvantagesFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('CorahnRinModelsBundle:Avantages');

        /** @var Books $book */
        $book = $this->getReference('corahnrin-book-2');

        $this->fixtureObject($repo, 1,1,'Allié isolé','Allié isolé',20,'Un allié dans un village, prévôt, marchand, artisan...',0,'',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 2,1,'Allié mentor','Allié mentor',40,'Un mentor ou un professeur qui vous donne un bonus de +1 dans un Domaine',0,'',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 3,1,'Allié influent','Allié influent',50,'Un important homme politique, chef de guilde ou de clan, qui a un pouvoir important dans tout le pays',0,'',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 4,2,'Aisance financière 1','Aisance financière 1',10,'+20 daols d\'azur à la création du personnage',0,'20a',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 5,2,'Aisance financière 2','Aisance financière 2',20,'+50 daols d\'azur à la création du personnage',0,'50a',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 6,2,'Aisance financière 3','Aisance financière 3',30,'+10 daols de givre à la création du personnage',0,'10g',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 7,2,'Aisance financière 4','Aisance financière 4',40,'+50 daols de givre à la création du personnage',0,'50g',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 8,2,'Aisance financière 5','Aisance financière 5',50,'+100 daols de givre à la création du personnage',0,'100g',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 9,null,'Beau','Belle',30,'+1 aux jets de Relation et Représentation',1,'11,12',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 10,null,'Bonne santé','Bonne santé',40,'+1 case d\'état de santé, +1 aux jets de Vigueur face à la maladie et aux poisons',1,'bless',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 11,null,'Bonne vue','Bonne vue',30,'+1 aux jets de Perception concernant la vue et Tir et Lancer',1,'8,14',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 12,null,'Charismatique','Charismatique',30,'+1 aux jets de Relation et Représentation',1,'11,12',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 13,null,'Endurant','Endurante',30,'+1 au score de Vigueur et aux jets de Prouesses concernant l\'endurance',1,'vig,10',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 14,null,'Esprit solide','Esprit solide',30,'+1 au score de Résistance Mentale',1,'resm',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 15,null,'Fort','Forte',40,'+1 aux jets de Prouesses concernant la force, Combat au Contact, Tir & lancer',1,'2,10,14',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 16,null,'Intuitif','Intuitive',40,'+1 aux jets de Mystères Demorthèn, Voyage et Relation',1,'6,11,15',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 17,null,'Leste','Leste',40,'+1 au score de Défense, et aux jets de Discrétion et de Prouesses concernant l\'agilité',1,'def,3,10',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 18,null,'Ouïe fine','Ouïe fine',20,'+1 aux jets de Perception auditive',1,8,0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 19,null,'Rapide','Rapide',20,'+1 au score de Rapidité',1,'rap',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 20,null,'Vif d\'esprit','Vive d\'esprit',40,'+1 aux jets de Science, Magience et Occultisme',1,'4,7,13',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 21,null,'Chanceux','Chanceuse',30,'+1 aux jets de Chance',1,'',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 22,null,'Instinct de survie','Instinct de survie',30,'+1 point de Survie',1,'sur',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 23,null,'Lettré','Lettrée',20,'Le personnage sait lire et écrire, et choisit un bonus de +1 au choix : Erudition, Magience, Science ou Occultisme',0,'',0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 29,null,'Nez fin','Nez fin',10,'+1 aux jets de Perception concernant l\'odorat',1,8,0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 30,null,'Palais fin','Palais fin',10,'+1 aux jets de Perception concernant le goût',1,8,0,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 31,null,'Boiteux','Boiteuse',30,'-1 en Rapidité et en Défense',0,'def,rap',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 32,null,'Dépendance','Dépendance',20,'-1 en Vigueur, et une addiction (tabac, alcool, drogue...)',0,'vig',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 33,null,'Douillet','Douillette',20,'-1 au score de Vigueur et aux jets de Prouesses concernant l\'endurance',1,'vig,10',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 34,null,'Ennemi','Ennemi',30,'Une personne en veut au PJ et fera tout pour lui nuire',0,'',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 35,null,'Esprit faible','Esprit faible',20,'-1 au score de Résistance Mentale',1,'resm',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 36,null,'Faible','Faible',30,'-1 aux jets de Prouesses concernant la force, Combat au Contact, Tir & lancer',1,'2,10,14',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 37,null,'Lent d\'esprit','Lente d\'esprit',30,'-1 aux jets de Science, Magience et Occultisme',1,'4,7,13',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 38,null,'Fragile','Fragile',20,'-1 point de Survie',1,'sur',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 39,null,'Obtus','Obtuse',30,'-1 aux jets de Mystères Demorthèn, Voyage et Relation',1,'6,11,15',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 40,null,'Laid','Laide',20,'-1 aux jets de Relation et Représentation',1,'11,12',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 41,null,'Lent','Lente',10,'-1 au score de Rapidité',1,'rap',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 42,null,'Mal entendant','Mal entendante',20,'-1 aux jets de Perception auditive',1,8,1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 43,null,'Malchanceux','Malchanceuse',10,'-1 aux jets de Chance',1,'',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 44,null,'Maladif','Maladive',30,'-1 case d\'état de santé, -1 point de Vigueur',0,'bless,vig',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 45,null,'Maladroit','Maladroite',30,'-1 au score de Défense, et aux jets de Discrétion et de Prouesses concernant l\'agilité',1,'def,3,10',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 46,null,'Myope','Myope',20,'-1 aux jets de Perception concernant la vue et Tir et Lancer',1,'8,14',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 47,null,'Pauvre','Pauvre',10,'Le PJ ne disposera que du quart de la somme en Daols fournie à la création',0,'',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 48,null,'Phobie','Phobie',40,'+1 point de trauma, et souffre du désordre Phobie en plus de son désordre actuel',0,'trau',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 49,null,'Timide','Timide',10,'-1 aux jets de Relation et Représentation',0,'11,12',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 50,null,'Traumatisme','Traumatisme',10,'+1 point de trauma',1,'trau',1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 51,null,'Anosmie','Anosmie',5,'-1 aux jets de Perception concernant l\'odorat',1,8,1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);
        $this->fixtureObject($repo, 52,null,'Agueusie','Agueusie',5,'-1 aux jets de Perception concernant le goût',1,8,1,0,'2014-04-09 08:56:43','2014-04-09 08:56:43',null,$book);

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $group, $name, $nameFemale, $xp, $description, $augmentation, $bonusDisc, $isDesv, $isCombatArt, $created, $updated, $deleted = null, $book)
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
            $obj = new Avantages();
            $obj->setId($id)
                ->setGroup($group)
                ->setName($name)
                ->setXp($xp)
                ->setNameFemale($nameFemale)
                ->setDescription($description)
                ->setAugmentation($augmentation)
                ->setBonusdisc($bonusDisc)
                ->setIsDesv($isDesv)
                ->setIsCombatArt($isCombatArt)
                ->setBook($book)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
            ;
            if ($id) {
                /** @var ClassMetadata $metadata */
                $metadata = $this->manager->getClassMetaData(get_class($obj));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->manager->persist($obj);
            $addRef = true;
        }
        if ($addRef === true && $obj) {
            $this->addReference('corahnrin-avantage-'.$id, $obj);
        }
    }
}