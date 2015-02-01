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
    public function getOrder()
    {
        return 3;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
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
        $faction7 = $this->getReference('esterenmaps-factions-7');
        $faction8 = $this->getReference('esterenmaps-factions-8');
        $faction9 = $this->getReference('esterenmaps-factions-9');
        $faction10 = $this->getReference('esterenmaps-factions-10');
        $faction11 = $this->getReference('esterenmaps-factions-11');

        $markers = array(
            array('id' => '7','faction_id' => '9','map_id' => '1','name' => 'Tuaille','description' => '','altitude' => '0','latitude' => '43.516688535029','longitude' => '-108.80859375','created' => '2014-05-08 16:19:03','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '8','faction_id' => '11','map_id' => '1','name' => 'Osta-Baille','description' => '','altitude' => '0','latitude' => '60.75915950227','longitude' => '-78.9697265625','created' => '2014-05-08 16:20:09','updated' => '2014-05-10 17:08:44','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '9','faction_id' => '1','map_id' => '1','name' => 'Ard-Amrach','description' => '','altitude' => '0','latitude' => '81.485801987835','longitude' => '-112.7197265625','created' => '2014-05-08 16:28:04','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '10','faction_id' => '4','map_id' => '1','name' => 'Aimliu','description' => '','altitude' => '0','latitude' => '79.351472250007','longitude' => '-127.529296875','created' => '2014-05-08 16:28:04','updated' => '2014-05-10 16:57:25','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '11','faction_id' => '4','map_id' => '1','name' => 'Pont de l\'Alliance','description' => '','altitude' => '0','latitude' => '72.867930498614','longitude' => '-51.15234375','created' => '2014-05-08 16:28:04','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '12','faction_id' => '3','map_id' => '1','name' => 'Fairean Ear','description' => '','altitude' => '0','latitude' => '74.625100963872','longitude' => '-43.857421875','created' => '2014-05-08 16:28:04','updated' => '2014-05-10 17:08:05','deleted' => NULL,'markerType_id' => '4'),
            array('id' => '13','faction_id' => '2','map_id' => '1','name' => 'Kalvernach','description' => '','altitude' => '0','latitude' => '76.689905821569','longitude' => '-61.2158203125','created' => '2014-05-08 16:28:04','updated' => '2014-05-10 17:09:17','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '14','faction_id' => NULL,'map_id' => '1','name' => 'Carrefour de l\'entrée du Reizh','description' => '','altitude' => '0','latitude' => '75.464105104918','longitude' => '-53.19580078125','created' => '2014-05-08 16:31:48','updated' => '2014-05-08 16:33:21','deleted' => NULL,'markerType_id' => '3'),
            array('id' => '15','faction_id' => '10','map_id' => '1','name' => 'Kember','description' => '','altitude' => '0','latitude' => '81.208138929648','longitude' => '-40.869140625','created' => '2014-05-09 07:32:28','updated' => '2014-05-10 17:07:00','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '16','faction_id' => '10','map_id' => '1','name' => 'Pont du Donir de Kember','description' => '','altitude' => '0','latitude' => '80.983688308259','longitude' => '-42.5390625','created' => '2014-05-09 07:32:28','updated' => '2014-06-12 19:30:05','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '17','faction_id' => '10','map_id' => '1','name' => 'Pont de l\'Oëss de Kember','description' => '','altitude' => '0','latitude' => '81.200299114726','longitude' => '-38.334960713983','created' => '2014-05-09 07:32:28','updated' => '2014-05-10 17:07:31','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '18','faction_id' => '9','map_id' => '1','name' => 'Château des Mac Emmanon','description' => '','altitude' => '0','latitude' => '81.138459095287','longitude' => '-48.363281562924','created' => '2014-05-10 17:33:29','updated' => '2014-05-10 17:34:02','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '19','faction_id' => '2','map_id' => '1','name' => 'Clos-des-Cendres','description' => '','altitude' => '0','latitude' => '84.186870998601','longitude' => '-39.213866963983','created' => '2014-05-10 17:38:11','updated' => '2014-05-10 17:39:01','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '20','faction_id' => '1','map_id' => '1','name' => 'Fionnfuar','description' => '','altitude' => '0','latitude' => '83.978491200531','longitude' => '-52.309570088983','created' => '2014-05-10 17:54:32','updated' => '2014-05-17 13:59:04','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '21','faction_id' => '9','map_id' => '1','name' => 'Farl','description' => '','altitude' => '0','latitude' => '83.847239701688','longitude' => '-16.992187052965','created' => '2014-05-10 17:54:32','updated' => '2014-05-17 13:59:04','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '22','faction_id' => '9','map_id' => '1','name' => 'Kermordhran','description' => '','altitude' => '0','latitude' => '82.580433663115','longitude' => '-36.826171875','created' => '2014-05-10 17:54:32','updated' => '2014-06-12 19:03:53','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '23','faction_id' => '4','map_id' => '1','name' => 'Afalinn','description' => '','altitude' => '0','latitude' => '80.725268622776','longitude' => '-45.0439453125','created' => '2014-05-23 21:21:02','updated' => '2014-06-12 22:40:17','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '24','faction_id' => '4','map_id' => '1','name' => 'Entrée du Cirque d\'Argoneskan','description' => '','altitude' => '0','latitude' => '83.311912235113','longitude' => '-36.849609687924','created' => '2014-06-12 19:03:53','updated' => '2014-06-12 19:06:34','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '25','faction_id' => '1','map_id' => '1','name' => 'Gouvran','description' => '','altitude' => '0','latitude' => '84.029750297517','longitude' => '-77.6953125','created' => '2014-06-12 19:03:53','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '26','faction_id' => '10','map_id' => '1','name' => 'Nectan','description' => '','altitude' => '0','latitude' => '82.956511348774','longitude' => '-98.26171875','created' => '2014-06-12 19:03:53','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '27','faction_id' => '10','map_id' => '1','name' => 'Deh\'ad','description' => '','altitude' => '0','latitude' => '83.7491278189','longitude' => '-57.48046875','created' => '2014-06-12 19:03:53','updated' => '2014-06-12 19:34:06','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '28','faction_id' => '4','map_id' => '1','name' => 'Lenbach','description' => '','altitude' => '0','latitude' => '83.232975287495','longitude' => '-73.611328750849','created' => '2014-06-12 19:03:53','updated' => '2014-06-12 19:06:34','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '29','faction_id' => '11','map_id' => '1','name' => 'Pierres brisées','description' => '','altitude' => '0','latitude' => '83.53996971923','longitude' => '-57.392578125','created' => '2014-06-12 19:03:53','updated' => '2014-06-12 19:06:34','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '30','faction_id' => '1','map_id' => '1','name' => 'Abbaye de Corvus','description' => '','altitude' => '0','latitude' => '82.297120961635','longitude' => '-59.0625','created' => '2014-06-12 19:23:58','updated' => '2014-06-12 19:27:54','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '31','faction_id' => '9','map_id' => '1','name' => 'Les Hauts-Vents','description' => '','altitude' => '0','latitude' => '82.213224838025','longitude' => '-50.639648213983','created' => '2014-06-12 19:23:58','updated' => '2014-06-12 19:27:54','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '32','faction_id' => '4','map_id' => '1','name' => 'Gué sanglant','description' => '','altitude' => '0','latitude' => '81.433593340862','longitude' => '-51.85546875','created' => '2014-06-12 19:30:05','updated' => '2014-06-12 22:41:07','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '33','faction_id' => '9','map_id' => '1','name' => 'Demeure des Mac Baellec','description' => '','altitude' => '0','latitude' => '77.513624042495','longitude' => '-56.337890625','created' => '2014-06-12 19:45:04','updated' => '2014-06-12 22:39:04','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '34','faction_id' => '10','map_id' => '1','name' => 'Crail','description' => '','altitude' => '0','latitude' => '75.511823686948','longitude' => '-70.623047500849','created' => '2014-06-12 19:45:04','updated' => '2014-06-12 19:49:16','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '35','faction_id' => '11','map_id' => '1','name' => 'Gline','description' => '','altitude' => '0','latitude' => '73.914353562816','longitude' => '-69.832031875849','created' => '2014-06-12 19:45:04','updated' => '2014-06-12 19:49:16','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '36','faction_id' => '10','map_id' => '1','name' => 'Leacah','description' => '','altitude' => '0','latitude' => '73.669028766658','longitude' => '-75.896485000849','created' => '2014-06-12 19:45:04','updated' => '2014-06-12 19:49:16','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '37','faction_id' => '2','map_id' => '1','name' => 'Promesse','description' => '','altitude' => '0','latitude' => '80.675558819735','longitude' => '-55.458984375','created' => '2014-06-12 20:01:10','updated' => '2014-06-12 22:37:16','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '38','faction_id' => '2','map_id' => '1','name' => 'Mines de Promesse','description' => '','altitude' => '0','latitude' => '80.558540053033','longitude' => '-57.372070625424','created' => '2014-06-12 20:01:10','updated' => '2014-06-12 20:15:01','deleted' => NULL,'markerType_id' => '7'),
            array('id' => '39','faction_id' => '4','map_id' => '1','name' => 'Iolairnead','description' => '','altitude' => '0','latitude' => '82.506294787715','longitude' => '5.3144524991512','created' => '2014-06-12 20:15:00','updated' => '2014-06-12 22:13:31','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '40','faction_id' => '4','map_id' => '1','name' => 'Col de Gaos-Bodhar','description' => '','altitude' => '0','latitude' => '79.22897540022','longitude' => '25.0048828125','created' => '2014-06-12 20:15:00','updated' => '2014-06-17 17:14:33','deleted' => NULL,'markerType_id' => '3'),
            array('id' => '41','faction_id' => '11','map_id' => '1','name' => 'Ear Caladh','description' => '','altitude' => '0','latitude' => '79.818777486993','longitude' => '-35.478515401483','created' => '2014-06-13 14:08:58','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '42','faction_id' => '11','map_id' => '1','name' => 'Baldh-Ruoch','description' => '','altitude' => '0','latitude' => '80.222343861786','longitude' => '-32.666015401483','created' => '2014-06-13 14:08:58','updated' => '2014-06-13 14:11:40','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '43','faction_id' => '11','map_id' => '1','name' => 'Ruines du château des Mac Farquam','description' => '','altitude' => '0','latitude' => '70.22974449563','longitude' => '-129.287109375','created' => '2014-06-13 17:17:05','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '44','faction_id' => '11','map_id' => '1','name' => 'Caiginn','description' => '','altitude' => '0','latitude' => '70.863889877509','longitude' => '-100.59375062585','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '45','faction_id' => '11','map_id' => '1','name' => 'Gorm Caladh','description' => '','altitude' => '0','latitude' => '74.441501486394','longitude' => '-143.66015687585','created' => '2014-06-13 17:29:47','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '46','faction_id' => '1','map_id' => '1','name' => 'Cathédrale Saint Albérich','description' => '','altitude' => '0','latitude' => '77.421445002889','longitude' => '-133.28906312585','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '47','faction_id' => '11','map_id' => '1','name' => 'Tulg Naomh','description' => '','altitude' => '0','latitude' => '65.573608070692','longitude' => '-151.13086000085','created' => '2014-06-13 17:29:47','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '48','faction_id' => '4','map_id' => '1','name' => 'Dearg','description' => '','altitude' => '0','latitude' => '70.911851391151','longitude' => '-107.16210968792','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '49','faction_id' => '11','map_id' => '1','name' => 'Fearìl','description' => '','altitude' => '0','latitude' => '70.897475078797','longitude' => '-108.48046906292','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '50','faction_id' => '11','map_id' => '1','name' => 'Château de Smioraìl','description' => '','altitude' => '0','latitude' => '70.796548673277','longitude' => '-109.00781281292','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '51','faction_id' => '4','map_id' => '1','name' => 'Loch Varn','description' => '','altitude' => '0','latitude' => '70.387689996927','longitude' => '-105.66796906292','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '52','faction_id' => '4','map_id' => '1','name' => 'Col d\'Oerdh','description' => '','altitude' => '0','latitude' => '70.32860299532','longitude' => '-101.27343781292','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '53','faction_id' => '4','map_id' => '1','name' => 'Arngyll','description' => '','altitude' => '0','latitude' => '69.063329480041','longitude' => '-138.40722687542','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '54','faction_id' => '4','map_id' => '1','name' => 'Helefrt','description' => '','altitude' => '0','latitude' => '70.387689996927','longitude' => '-115.24804718792','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '55','faction_id' => '11','map_id' => '1','name' => 'Terkhên','description' => '','altitude' => '0','latitude' => '65.718582059732','longitude' => '-118.78711000085','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '56','faction_id' => '9','map_id' => '1','name' => 'Frendian','description' => '','altitude' => '0','latitude' => '66.148666883388','longitude' => '-102.79101625085','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '57','faction_id' => '11','map_id' => '1','name' => 'Mambrun','description' => '','altitude' => '0','latitude' => '72.650854589766','longitude' => '-115.97461000085','created' => '2014-06-13 17:29:47','updated' => '2014-06-13 17:42:02','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '58','faction_id' => '9','map_id' => '1','name' => 'Château des Roharën','description' => '','altitude' => '0','latitude' => '80.923805412292','longitude' => '-25.095703750849','created' => '2014-06-13 17:42:02','updated' => '2014-06-13 18:02:39','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '59','faction_id' => '11','map_id' => '1','name' => 'Ard-Monach','description' => '','altitude' => '0','latitude' => '68.715123824072','longitude' => '-93.802734687924','created' => '2014-06-13 17:42:02','updated' => '2014-06-13 18:02:39','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '60','faction_id' => '9','map_id' => '1','name' => 'Bas-Mùdan','description' => '','altitude' => '0','latitude' => '64.49803273342','longitude' => '-82.312500625849','created' => '2014-06-13 17:42:02','updated' => '2014-06-13 18:02:39','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '61','faction_id' => '3','map_id' => '1','name' => 'Haut-Mùdan','description' => '','altitude' => '0','latitude' => '64.422246649867','longitude' => '-79.763672500849','created' => '2014-06-13 17:42:02','updated' => '2014-06-13 18:02:39','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '62','faction_id' => '4','map_id' => '1','name' => 'Carrefour de Ruel','description' => '','altitude' => '0','latitude' => '68.160659347746','longitude' => '-71.238281875849','created' => '2014-06-13 17:42:02','updated' => '2014-06-13 18:02:39','deleted' => NULL,'markerType_id' => '3'),
            array('id' => '63','faction_id' => '11','map_id' => '1','name' => 'Koskan','description' => '','altitude' => '0','latitude' => '53.783344888615','longitude' => '-70.535156875849','created' => '2014-06-13 17:42:02','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '64','faction_id' => '1','map_id' => '1','name' => 'Saint Persked','description' => '','altitude' => '0','latitude' => '82.001019730026','longitude' => '-135.28710968792','created' => '2014-06-13 18:02:39','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '65','faction_id' => '1','map_id' => '1','name' => 'Sant Heskenen','description' => '','altitude' => '0','latitude' => '81.232733188501','longitude' => '-142.40625031292','created' => '2014-06-13 18:02:39','updated' => '2014-06-13 18:04:31','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '66','faction_id' => '1','map_id' => '1','name' => 'Sainte Nihesk','description' => '','altitude' => '0','latitude' => '80.100951676273','longitude' => '-141.35156281292','created' => '2014-06-13 18:02:39','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '67','faction_id' => '1','map_id' => '1','name' => 'Saint Arpan','description' => '','altitude' => '0','latitude' => '80.153695377962','longitude' => '-146.88867218792','created' => '2014-06-13 18:02:39','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '68','faction_id' => '9','map_id' => '1','name' => 'Le Roc','description' => '','altitude' => '0','latitude' => '82.74690205692','longitude' => '-138.71484406292','created' => '2014-06-13 18:02:39','updated' => '2014-06-13 18:04:31','deleted' => NULL,'markerType_id' => '6'),
            array('id' => '69','faction_id' => '11','map_id' => '1','name' => 'Rhingal','description' => '','altitude' => '0','latitude' => '80.572946711951','longitude' => '-110.10644562542','created' => '2014-06-13 18:02:39','updated' => '2014-06-13 18:04:31','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '70','faction_id' => '9','map_id' => '1','name' => 'Llewellen','description' => '','altitude' => '0','latitude' => '59.756395049356','longitude' => '-151.41503937542','created' => '2014-06-13 18:02:39','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '71','faction_id' => '1','map_id' => '1','name' => 'Expiation','description' => '','altitude' => '0','latitude' => '73.082370953776','longitude' => '-91.429687812924','created' => '2014-06-13 18:18:41','updated' => '2014-06-13 18:43:36','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '72','faction_id' => '11','map_id' => '1','name' => 'Seòl','description' => '','altitude' => '0','latitude' => '64.973163401028','longitude' => '-40.523438751698','created' => '2014-06-13 18:18:41','updated' => '2014-06-17 17:30:09','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '73','faction_id' => '11','map_id' => '1','name' => 'Kel Loar','description' => '','altitude' => '0','latitude' => '72.536923673363','longitude' => '-48.363281562924','created' => '2014-06-13 18:18:41','updated' => '2014-06-13 18:43:36','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '74','faction_id' => '4','map_id' => '1','name' => 'L\'îlot d\'Eschen','description' => '','altitude' => '0','latitude' => '67.875541346729','longitude' => '-34.432617500424','created' => '2014-06-13 18:18:41','updated' => '2014-06-13 18:43:36','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '75','faction_id' => '3','map_id' => '1','name' => 'Didean','description' => '','altitude' => '0','latitude' => '70.048097171974','longitude' => '-114.05273415148','created' => '2014-06-15 20:42:59','updated' => '2014-06-17 13:53:41','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '76','faction_id' => '6','map_id' => '1','name' => 'Pointe de Hòb','description' => '','altitude' => '0','latitude' => '29.356643947997','longitude' => '-157.54687562585','created' => '2014-06-17 17:30:09','updated' => '2014-06-17 17:31:22','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '77','faction_id' => '4','map_id' => '1','name' => 'Cap des Adieux','description' => '','altitude' => '0','latitude' => '26.954717805555','longitude' => '-157.63476625085','created' => '2014-06-17 17:30:09','updated' => '2014-06-17 17:31:22','deleted' => NULL,'markerType_id' => '5'),
            array('id' => '78','faction_id' => '5','map_id' => '1','name' => 'Iolach','description' => '','altitude' => '0','latitude' => '28.097828285526','longitude' => '-145.8164075017','created' => '2014-06-17 17:30:09','updated' => '2014-06-17 17:31:22','deleted' => NULL,'markerType_id' => '2'),
            array('id' => '79','faction_id' => '9','map_id' => '1','name' => 'Merieren','description' => '','altitude' => '0','latitude' => '56.860985750645','longitude' => '-101.1181640625','created' => '2014-06-24 11:42:58','updated' => '2014-06-24 12:09:08','deleted' => NULL,'markerType_id' => '1'),
            array('id' => '80','faction_id' => '11','map_id' => '1','name' => 'Aelwyd Saogh','description' => '','altitude' => '0','latitude' => '71.436508079644','longitude' => '-85.771728828549','created' => '2014-06-30 18:00:25','updated' => '2014-06-30 18:10:17','deleted' => NULL,'markerType_id' => '6')
        );

        foreach ($markers as $marker) {
            $faction = $marker['faction_id'] ? 'faction'.$marker['faction_id'] : null;
            $map = 'map'.$marker['map_id'];
            $markerType = 'markerType'.$marker['markerType_id'];
            $this->fixtureObject($repo, $marker['id'], $faction ? $$faction : null, $$map, $marker['name'], $marker['created'], $marker['updated'], $marker['deleted'], $$markerType, $marker['altitude'], $marker['latitude'], $marker['longitude'], $marker['description']);
        }

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