<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;

class MarkersFixtures extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Factions[]
     */
    private $factions = array();

    /**
     * @var Maps[]
     */
    private $maps;

    /**
     * Get the order of this fixture
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:Markers');

        $map1 = $this->getReference('esterenmaps-maps-1');

        $markerType1 = $this->getReference('esterenmaps-markerstypes-1');
        $markerType2 = $this->getReference('esterenmaps-markerstypes-2');
        $markerType3 = $this->getReference('esterenmaps-markerstypes-3');
        $markerType4 = $this->getReference('esterenmaps-markerstypes-4');
        $markerType5 = $this->getReference('esterenmaps-markerstypes-5');
        $markerType6 = $this->getReference('esterenmaps-markerstypes-6');
        $markerType7 = $this->getReference('esterenmaps-markerstypes-7');

        $faction1 = $this->getReference('esterenmaps-factions-1');
        $faction2 = $this->getReference('esterenmaps-factions-2');
        $faction3 = $this->getReference('esterenmaps-factions-3');
        $faction4 = $this->getReference('esterenmaps-factions-4');
        $faction5 = $this->getReference('esterenmaps-factions-5');
        $faction6 = $this->getReference('esterenmaps-factions-6');
//        $faction7 = $this->getReference('esterenmaps-factions-7');
//        $faction8 = $this->getReference('esterenmaps-factions-8');
        $faction9 = $this->getReference('esterenmaps-factions-9');
        $faction10 = $this->getReference('esterenmaps-factions-10');
        $faction11 = $this->getReference('esterenmaps-factions-11');

        $this->fixtureObject($repo, 7, $faction9, $map1, 'Tuaille', '2014-05-08 16:19:03', '2014-06-17 17:30:09', null, $markerType2, 0, 43.516688535029, -108.80859375, '');
        $this->fixtureObject($repo, 8, $faction11, $map1, 'Osta-Baille', '2014-05-08 16:20:09', '2014-05-10 17:08:44', null, $markerType1, 0, 60.75915950227, -78.9697265625, '');
        $this->fixtureObject($repo, 9, $faction1, $map1, 'Ard-Amrach', '2014-05-08 16:28:04', '2014-06-30 17:58:18', null, $markerType1, 0, 81.485801987835, -112.7197265625, '');
        $this->fixtureObject($repo, 10, $faction4, $map1, 'Aimliu', '2014-05-08 16:28:04', '2014-05-10 16:57:25', null, $markerType2, 0, 79.351472250007, -127.529296875, '');
        $this->fixtureObject($repo, 11, $faction4, $map1, 'Pont de l\'Alliance', '2014-05-08 16:28:04', '2014-06-13 17:42:02', null, $markerType1, 0, 72.867930498614, -51.15234375, '');
        $this->fixtureObject($repo, 12, $faction3, $map1, 'Fairean Ear', '2014-05-08 16:28:04', '2014-05-10 17:08:05', null, $markerType4, 0, 74.625100963872, -43.857421875, '');
        $this->fixtureObject($repo, 13, $faction2, $map1, 'Kalvernach', '2014-05-08 16:28:04', '2014-05-10 17:09:17', null, $markerType1, 0, 76.689905821569, -61.2158203125, '');
        $this->fixtureObject($repo, 14, null, $map1, 'Carrefour de l\'entrée du Reizh', '2014-05-08 16:31:48', '2014-05-08 16:33:21', null, $markerType3, 0, 75.464105104918, -53.19580078125, '');
        $this->fixtureObject($repo, 15, $faction10, $map1, 'Kember', '2014-05-09 07:32:28', '2014-05-10 17:07:00', null, $markerType1, 0, 81.208138929648, -40.869140625, '');
        $this->fixtureObject($repo, 16, $faction10, $map1, 'Pont du Donir de Kember', '2014-05-09 07:32:28', '2014-06-12 19:30:05', null, $markerType1, 0, 80.983688308259, -42.5390625, '');
        $this->fixtureObject($repo, 17, $faction10, $map1, 'Pont de l\'Oëss de Kember', '2014-05-09 07:32:28', '2014-05-10 17:07:31', null, $markerType1, 0, 81.200299114726, -38.334960713983, '');
        $this->fixtureObject($repo, 18, $faction9, $map1, 'Château des Mac Emmanon', '2014-05-10 17:33:29', '2014-05-10 17:34:02', null, $markerType6, 0, 81.138459095287, -48.363281562924, '');
        $this->fixtureObject($repo, 19, $faction2, $map1, 'Clos-des-Cendres', '2014-05-10 17:38:11', '2014-05-10 17:39:01', null, $markerType1, 0, 84.186870998601, -39.213866963983, '');
        $this->fixtureObject($repo, 20, $faction1, $map1, 'Fionnfuar', '2014-05-10 17:54:32', '2014-05-17 13:59:04', null, $markerType1, 0, 83.978491200531, -52.309570088983, '');
        $this->fixtureObject($repo, 21, $faction9, $map1, 'Farl', '2014-05-10 17:54:32', '2014-05-17 13:59:04', null, $markerType1, 0, 83.847239701688, -16.992187052965, '');
        $this->fixtureObject($repo, 22, $faction9, $map1, 'Kermordhran', '2014-05-10 17:54:32', '2014-06-12 19:03:53', null, $markerType1, 0, 82.580433663115, -36.826171875, '');
        $this->fixtureObject($repo, 23, $faction4, $map1, 'Afalinn', '2014-05-23 21:21:02', '2014-06-12 22:40:17', null, $markerType1, 0, 80.725268622776, -45.0439453125, '');
        $this->fixtureObject($repo, 24, $faction4, $map1, 'Entrée du Cirque d\'Argoneskan', '2014-06-12 19:03:53', '2014-06-12 19:06:34', null, $markerType5, 0, 83.311912235113, -36.849609687924, '');
        $this->fixtureObject($repo, 25, $faction1, $map1, 'Gouvran', '2014-06-12 19:03:53', '2014-06-30 17:58:18', null, $markerType1, 0, 84.029750297517, -77.6953125, '');
        $this->fixtureObject($repo, 26, $faction10, $map1, 'Nectan', '2014-06-12 19:03:53', '2014-06-30 17:58:18', null, $markerType1, 0, 82.956511348774, -98.26171875, '');
        $this->fixtureObject($repo, 27, $faction10, $map1, 'Deh\'ad', '2014-06-12 19:03:53', '2014-06-12 19:34:06', null, $markerType1, 0, 83.7491278189, -57.48046875, '');
        $this->fixtureObject($repo, 28, $faction4, $map1, 'Lenbach', '2014-06-12 19:03:53', '2014-06-12 19:06:34', null, $markerType1, 0, 83.232975287495, -73.611328750849, '');
        $this->fixtureObject($repo, 29, $faction11, $map1, 'Pierres brisées', '2014-06-12 19:03:53', '2014-06-12 19:06:34', null, $markerType5, 0, 83.53996971923, -57.392578125, '');
        $this->fixtureObject($repo, 30, $faction1, $map1, 'Abbaye de Corvus', '2014-06-12 19:23:58', '2014-06-12 19:27:54', null, $markerType1, 0, 82.297120961635, -59.0625, '');
        $this->fixtureObject($repo, 31, $faction9, $map1, 'Les Hauts-Vents', '2014-06-12 19:23:58', '2014-06-12 19:27:54', null, $markerType6, 0, 82.213224838025, -50.639648213983, '');
        $this->fixtureObject($repo, 32, $faction4, $map1, 'Gué sanglant', '2014-06-12 19:30:05', '2014-06-12 22:41:07', null, $markerType5, 0, 81.433593340862, -51.85546875, '');
        $this->fixtureObject($repo, 33, $faction9, $map1, 'Demeure des Mac Baellec', '2014-06-12 19:45:04', '2014-06-12 22:39:04', null, $markerType6, 0, 77.513624042495, -56.337890625, '');
        $this->fixtureObject($repo, 34, $faction10, $map1, 'Crail', '2014-06-12 19:45:04', '2014-06-12 19:49:16', null, $markerType1, 0, 75.511823686948, -70.623047500849, '');
        $this->fixtureObject($repo, 35, $faction11, $map1, 'Gline', '2014-06-12 19:45:04', '2014-06-12 19:49:16', null, $markerType1, 0, 73.914353562816, -69.832031875849, '');
        $this->fixtureObject($repo, 36, $faction10, $map1, 'Leacah', '2014-06-12 19:45:04', '2014-06-12 19:49:16', null, $markerType1, 0, 73.669028766658, -75.896485000849, '');
        $this->fixtureObject($repo, 37, $faction2, $map1, 'Promesse', '2014-06-12 20:01:10', '2014-06-12 22:37:16', null, $markerType1, 0, 80.675558819735, -55.458984375, '');
        $this->fixtureObject($repo, 38, $faction2, $map1, 'Mines de Promesse', '2014-06-12 20:01:10', '2014-06-12 20:15:01', null, $markerType7, 0, 80.558540053033, -57.372070625424, '');
        $this->fixtureObject($repo, 39, $faction4, $map1, 'Iolairnead', '2014-06-12 20:15:00', '2014-06-12 22:13:31', null, $markerType1, 0, 82.506294787715, 5.3144524991512, '');
        $this->fixtureObject($repo, 40, $faction4, $map1, 'Col de Gaos-Bodhar', '2014-06-12 20:15:00', '2014-06-17 17:14:33', null, $markerType3, 0, 79.22897540022, 25.0048828125, '');
        $this->fixtureObject($repo, 41, $faction11, $map1, 'Ear Caladh', '2014-06-13 14:08:58', '2014-06-17 17:30:09', null, $markerType2, 0, 79.818777486993, -35.478515401483, '');
        $this->fixtureObject($repo, 42, $faction11, $map1, 'Baldh-Ruoch', '2014-06-13 14:08:58', '2014-06-13 14:11:40', null, $markerType1, 0, 80.222343861786, -32.666015401483, '');
        $this->fixtureObject($repo, 43, $faction11, $map1, 'Ruines du château des Mac Farquam', '2014-06-13 17:17:05', '2014-06-13 17:42:02', null, $markerType6, 0, 70.22974449563, -129.287109375, '');
        $this->fixtureObject($repo, 44, $faction11, $map1, 'Caiginn', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 70.863889877509, -100.59375062585, '');
        $this->fixtureObject($repo, 45, $faction11, $map1, 'Gorm Caladh', '2014-06-13 17:29:47', '2014-06-17 17:30:09', null, $markerType2, 0, 74.441501486394, -143.66015687585, '');
        $this->fixtureObject($repo, 46, $faction1, $map1, 'Cathédrale Saint Albérich', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 77.421445002889, -133.28906312585, '');
        $this->fixtureObject($repo, 47, $faction11, $map1, 'Tulg Naomh', '2014-06-13 17:29:47', '2014-06-17 17:30:09', null, $markerType2, 0, 65.573608070692, -151.13086000085, '');
        $this->fixtureObject($repo, 48, $faction4, $map1, 'Dearg', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 70.911851391151, -107.16210968792, '');
        $this->fixtureObject($repo, 49, $faction11, $map1, 'Fearìl', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 70.897475078797, -108.48046906292, '');
        $this->fixtureObject($repo, 50, $faction11, $map1, 'Château de Smioraìl', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType6, 0, 70.796548673277, -109.00781281292, '');
        $this->fixtureObject($repo, 51, $faction4, $map1, 'Loch Varn', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 70.387689996927, -105.66796906292, '');
        $this->fixtureObject($repo, 52, $faction4, $map1, 'Col d\'Oerdh', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType5, 0, 70.32860299532, -101.27343781292, '');
        $this->fixtureObject($repo, 53, $faction4, $map1, 'Arngyll', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 69.063329480041, -138.40722687542, '');
        $this->fixtureObject($repo, 54, $faction4, $map1, 'Helefrt', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 70.387689996927, -115.24804718792, '');
        $this->fixtureObject($repo, 55, $faction11, $map1, 'Terkhên', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 65.718582059732, -118.78711000085, '');
        $this->fixtureObject($repo, 56, $faction9, $map1, 'Frendian', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 66.148666883388, -102.79101625085, '');
        $this->fixtureObject($repo, 57, $faction11, $map1, 'Mambrun', '2014-06-13 17:29:47', '2014-06-13 17:42:02', null, $markerType1, 0, 72.650854589766, -115.97461000085, '');
        $this->fixtureObject($repo, 58, $faction9, $map1, 'Château des Roharën', '2014-06-13 17:42:02', '2014-06-13 18:02:39', null, $markerType6, 0, 80.923805412292, -25.095703750849, '');
        $this->fixtureObject($repo, 59, $faction11, $map1, 'Ard-Monach', '2014-06-13 17:42:02', '2014-06-13 18:02:39', null, $markerType1, 0, 68.715123824072, -93.802734687924, '');
        $this->fixtureObject($repo, 60, $faction9, $map1, 'Bas-Mùdan', '2014-06-13 17:42:02', '2014-06-13 18:02:39', null, $markerType1, 0, 64.49803273342, -82.312500625849, '');
        $this->fixtureObject($repo, 61, $faction3, $map1, 'Haut-Mùdan', '2014-06-13 17:42:02', '2014-06-13 18:02:39', null, $markerType1, 0, 64.422246649867, -79.763672500849, '');
        $this->fixtureObject($repo, 62, $faction4, $map1, 'Carrefour de Ruel', '2014-06-13 17:42:02', '2014-06-13 18:02:39', null, $markerType3, 0, 68.160659347746, -71.238281875849, '');
        $this->fixtureObject($repo, 63, $faction11, $map1, 'Koskan', '2014-06-13 17:42:02', '2014-06-17 17:30:09', null, $markerType2, 0, 53.783344888615, -70.535156875849, '');
        $this->fixtureObject($repo, 64, $faction1, $map1, 'Saint Persked', '2014-06-13 18:02:39', '2014-06-17 17:30:09', null, $markerType2, 0, 82.001019730026, -135.28710968792, '');
        $this->fixtureObject($repo, 65, $faction1, $map1, 'Sant Heskenen', '2014-06-13 18:02:39', '2014-06-13 18:04:31', null, $markerType1, 0, 81.232733188501, -142.40625031292, '');
        $this->fixtureObject($repo, 66, $faction1, $map1, 'Sainte Nihesk', '2014-06-13 18:02:39', '2014-06-17 17:30:09', null, $markerType2, 0, 80.100951676273, -141.35156281292, '');
        $this->fixtureObject($repo, 67, $faction1, $map1, 'Saint Arpan', '2014-06-13 18:02:39', '2014-06-17 17:30:09', null, $markerType2, 0, 80.153695377962, -146.88867218792, '');
        $this->fixtureObject($repo, 68, $faction9, $map1, 'Le Roc', '2014-06-13 18:02:39', '2014-06-13 18:04:31', null, $markerType6, 0, 82.74690205692, -138.71484406292, '');
        $this->fixtureObject($repo, 69, $faction11, $map1, 'Rhingal', '2014-06-13 18:02:39', '2014-06-13 18:04:31', null, $markerType1, 0, 80.572946711951, -110.10644562542, '');
        $this->fixtureObject($repo, 70, $faction9, $map1, 'Llewellen', '2014-06-13 18:02:39', '2014-06-17 17:30:09', null, $markerType2, 0, 59.756395049356, -151.41503937542, '');
        $this->fixtureObject($repo, 71, $faction1, $map1, 'Expiation', '2014-06-13 18:18:41', '2014-06-13 18:43:36', null, $markerType1, 0, 73.082370953776, -91.429687812924, '');
        $this->fixtureObject($repo, 72, $faction11, $map1, 'Seòl', '2014-06-13 18:18:41', '2014-06-17 17:30:09', null, $markerType2, 0, 64.973163401028, -40.523438751698, '');
        $this->fixtureObject($repo, 73, $faction11, $map1, 'Kel Loar', '2014-06-13 18:18:41', '2014-06-13 18:43:36', null, $markerType1, 0, 72.536923673363, -48.363281562924, '');
        $this->fixtureObject($repo, 74, $faction4, $map1, 'L\'îlot d\'Eschen', '2014-06-13 18:18:41', '2014-06-13 18:43:36', null, $markerType5, 0, 67.875541346729, -34.432617500424, '');
        $this->fixtureObject($repo, 75, $faction3, $map1, 'Didean', '2014-06-15 20:42:59', '2014-06-17 13:53:41', null, $markerType1, 0, 70.048097171974, -114.05273415148, '');
        $this->fixtureObject($repo, 76, $faction6, $map1, 'Pointe de Hòb', '2014-06-17 17:30:09', '2014-06-17 17:31:22', null, $markerType5, 0, 29.356643947997, -157.54687562585, '');
        $this->fixtureObject($repo, 77, $faction4, $map1, 'Cap des Adieux', '2014-06-17 17:30:09', '2014-06-17 17:31:22', null, $markerType5, 0, 26.954717805555, -157.63476625085, '');
        $this->fixtureObject($repo, 78, $faction5, $map1, 'Iolach', '2014-06-17 17:30:09', '2014-06-17 17:31:22', null, $markerType2, 0, 28.097828285526, -145.8164075017, '');
        $this->fixtureObject($repo, 79, $faction9, $map1, 'Merieren', '2014-06-24 11:42:58', '2014-06-24 12:09:08', null, $markerType1, 0, 56.860985750645, -101.1181640625, '');
        $this->fixtureObject($repo, 80, $faction11, $map1, 'Aelwyd Saogh', '2014-06-30 18:00:25', '2014-06-30 18:10:17', null, $markerType6, 0, 71.436508079644, -85.771728828549, '');

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $faction, $map, $name, $created, $updated, $deleted, $markerType, $altitude, $latitude, $longitude, $description)
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
            $obj = new Markers();
            $obj->setId($id)
                ->setName($name)
                ->setLatitude($latitude)
                ->setLongitude($longitude)
                ->setAltitude($altitude)
                ->setDescription($description)
                ->setFaction($faction)
                ->setMarkerType($markerType)
                ->setMap($map)
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
            $this->addReference('esterenmaps-markers-'.$id, $obj);
        }
    }
}