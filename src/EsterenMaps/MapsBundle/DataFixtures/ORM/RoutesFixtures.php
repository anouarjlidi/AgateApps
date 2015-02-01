<?php

namespace EsterenMaps\MapsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Routes;

class RoutesFixtures extends AbstractFixture implements OrderedFixtureInterface {

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
        return 4;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $repo = $this->manager->getRepository('EsterenMapsBundle:Routes');

        $map1 = $this->getReference('esterenmaps-maps-1');

        $routeType1 = $this->getReference('esterenmaps-routestypes-1');
        $routeType2 = $this->getReference('esterenmaps-routestypes-2');
        $routeType3 = $this->getReference('esterenmaps-routestypes-3');

        $faction1 = $this->getReference('esterenmaps-factions-1');
        $faction2 = $this->getReference('esterenmaps-factions-2');
        $faction4 = $this->getReference('esterenmaps-factions-4');
        $faction9 = $this->getReference('esterenmaps-factions-9');
        $faction10 = $this->getReference('esterenmaps-factions-10');
        $faction11 = $this->getReference('esterenmaps-factions-11');

        $marker7 = $this->getReference('esterenmaps-markers-7');
        $marker8 = $this->getReference('esterenmaps-markers-8');
        $marker9 = $this->getReference('esterenmaps-markers-9');
        $marker11 = $this->getReference('esterenmaps-markers-11');
        $marker12 = $this->getReference('esterenmaps-markers-12');
        $marker13 = $this->getReference('esterenmaps-markers-13');
        $marker14 = $this->getReference('esterenmaps-markers-14');
        $marker16 = $this->getReference('esterenmaps-markers-16');
        $marker17 = $this->getReference('esterenmaps-markers-17');
        $marker18 = $this->getReference('esterenmaps-markers-18');
        $marker19 = $this->getReference('esterenmaps-markers-19');
        $marker20 = $this->getReference('esterenmaps-markers-20');
        $marker21 = $this->getReference('esterenmaps-markers-21');
        $marker22 = $this->getReference('esterenmaps-markers-22');
        $marker23 = $this->getReference('esterenmaps-markers-23');
        $marker25 = $this->getReference('esterenmaps-markers-25');
        $marker26 = $this->getReference('esterenmaps-markers-26');
        $marker27 = $this->getReference('esterenmaps-markers-27');
        $marker31 = $this->getReference('esterenmaps-markers-31');
        $marker32 = $this->getReference('esterenmaps-markers-32');
        $marker33 = $this->getReference('esterenmaps-markers-33');
        $marker36 = $this->getReference('esterenmaps-markers-36');
        $marker38 = $this->getReference('esterenmaps-markers-38');
        $marker39 = $this->getReference('esterenmaps-markers-39');
        $marker40 = $this->getReference('esterenmaps-markers-40');
        $marker44 = $this->getReference('esterenmaps-markers-44');

        $routes = array(
            array('id' => '4','map_id' => '1','faction_id' => NULL,'name' => 'Route des capitales','coordinates' => '[{"lat":"43.516688535029","lng":"-108.80859375"},{"lat":44.339565248097,"lng":-109.70947265625},{"lat":44.871442750166,"lng":-108.78662109375},{"lat":45.213003555994,"lng":-109.18212890625},{"lat":45.521743896994,"lng":-109.44580078125},{"lat":46.25584681848,"lng":-109.92919921875},{"lat":46.920255315375,"lng":-109.97314453125},{"lat":47.309034247748,"lng":-109.53369140625},{"lat":47.635783590865,"lng":-109.22607421875},{"lat":47.960502388915,"lng":-108.65478515625},{"lat":48.370847702384,"lng":-108.87451171875},{"lat":49.239120832467,"lng":-109.05029296875},{"lat":50.261253827585,"lng":-109.00634765625},{"lat":50.597186230587,"lng":-108.65478515625},{"lat":51.069016659604,"lng":-108.39111328125},{"lat":51.645294049305,"lng":-108.61083984375},{"lat":52.052490476001,"lng":-108.91845703125},{"lat":52.589700768718,"lng":-108.83056640625},{"lat":52.988337253395,"lng":-108.30322265625},{"lat":53.383328367572,"lng":-107.38037109375},{"lat":53.618579364895,"lng":-106.63330078125},{"lat":53.981935162092,"lng":-105.62255859375},{"lat":54.367758524068,"lng":-104.56787109375},{"lat":55.503749859275,"lng":-103.29345703125},{"lat":56.145549500679,"lng":-102.32666015625},{"lat":57.064630273279,"lng":-101.25},{"lat":57.680660029772,"lng":-98.3056640625},{"lat":57.492213666701,"lng":-96.1962890625},{"lat":57.751075981321,"lng":-94.39453125},{"lat":57.844750992891,"lng":-93.18603515625},{"lat":58.240163543416,"lng":-91.77978515625},{"lat":58.654084645306,"lng":-90.41748046875},{"lat":58.90464570302,"lng":-88.39599609375},{"lat":58.813741715708,"lng":-86.72607421875},{"lat":58.859223547067,"lng":-84.79248046875},{"lat":58.859223547067,"lng":-83.82568359375},{"lat":58.927334418275,"lng":-82.94677734375},{"lat":59.017940339952,"lng":-81.45263671875},{"lat":59.017940339952,"lng":-80.13427734375},{"lat":59.198438575207,"lng":-78.90380859375},{"lat":59.377988012639,"lng":-77.40966796875},{"lat":59.534318001096,"lng":-76.92626953125},{"lat":59.933000423746,"lng":-76.97021484375},{"lat":60.108670463036,"lng":-77.32177734375},{"lat":60.326947742998,"lng":-77.89306640625},{"lat":"60.75915950227","lng":"-78.9697265625"}]','distance' => '48','created' => '2014-05-08 16:21:24','updated' => '2014-06-24 11:42:58','deleted' => NULL,'markerStart_id' => '7','markerEnd_id' => '8','routeType_id' => '1'),
            array('id' => '5','map_id' => '1','faction_id' => NULL,'name' => 'Nord du Pont de l\'Alliance','coordinates' => '[{"lat":"72.867930498614","lng":"-51.15234375"},{"lat":73.073843512772,"lng":-50.42724609375},{"lat":73.264703772638,"lng":-49.54833984375},{"lat":73.528399487652,"lng":-49.50439453125},{"lat":73.934634483268,"lng":-49.85595703125},{"lat":74.140083874405,"lng":-50.42724609375},{"lat":74.366674786724,"lng":-51.52587890625},{"lat":74.694854382545,"lng":-52.66845703125},{"lat":74.821934203565,"lng":-53.10791015625},{"lat":75.140777840704,"lng":-53.15185546875},{"lat":75.342281944273,"lng":-53.15185546875},{"lat":"75.464105104918","lng":"-53.19580078125"}]','distance' => '6','created' => '2014-05-08 16:33:21','updated' => '2014-06-10 22:55:35','deleted' => NULL,'markerStart_id' => '11','markerEnd_id' => '14','routeType_id' => '1'),
            array('id' => '6','map_id' => '1','faction_id' => NULL,'name' => 'Fairean Ear ouest','coordinates' => '[{"lat":"74.625100963872","lng":"-43.857421875"},{"lat":74.833435695818,"lng":-45.54931640625},{"lat":74.993565570822,"lng":-46.86767578125},{"lat":75.308884484761,"lng":-47.87841796875},{"lat":75.475130690901,"lng":-49.24072265625},{"lat":75.508158372309,"lng":-50.03173828125},{"lat":75.486148093683,"lng":-50.82275390625},{"lat":75.541112557811,"lng":-51.70166015625},{"lat":75.584937408692,"lng":-52.14111328125},{"lat":"75.464105104918","lng":"-53.19580078125"}]','distance' => '9','created' => '2014-05-08 16:33:21','updated' => '2014-06-10 22:55:35','deleted' => NULL,'markerStart_id' => '12','markerEnd_id' => '14','routeType_id' => '2'),
            array('id' => '7','map_id' => '1','faction_id' => NULL,'name' => 'Kalvernach est','coordinates' => '[{"lat":"76.689905821569","lng":"-61.2158203125"},{"lat":76.320753876849,"lng":-60.31494140625},{"lat":76.247816594415,"lng":-60.00732421875},{"lat":76.132429635544,"lng":-59.12841796875},{"lat":76.100796067546,"lng":-58.55712890625},{"lat":76.037316576165,"lng":-57.37060546875},{"lat":75.941564220328,"lng":-56.49169921875},{"lat":75.74812548843,"lng":-56.09619140625},{"lat":75.62863223279,"lng":-55.48095703125},{"lat":75.552080980283,"lng":-54.33837890625},{"lat":"75.464105104918","lng":"-53.19580078125"}]','distance' => '8','created' => '2014-05-08 16:33:21','updated' => '2014-06-10 22:55:35','deleted' => NULL,'markerStart_id' => '13','markerEnd_id' => '14','routeType_id' => '2'),
            array('id' => '8','map_id' => '1','faction_id' => NULL,'name' => 'Routes de Kember','coordinates' => '[{"lat":"80.983688308259","lng":"-42.5390625"},{"lat":81.154240958182,"lng":-41.484375},{"lat":81.253918645571,"lng":-40.795898213983},{"lat":81.214853225984,"lng":-39.55078125},{"lat":"81.200299114726","lng":"-38.334960713983"}]','distance' => '4','created' => '2014-05-09 07:32:28','updated' => '2014-06-12 19:30:05','deleted' => NULL,'markerStart_id' => '16','markerEnd_id' => '17','routeType_id' => '2'),
            array('id' => '9','map_id' => '1','faction_id' => '9','name' => 'Route de Gwidre','coordinates' => '[{"lat":"80.983688308259","lng":"-42.5390625"},{"lat":81.100015213897,"lng":-45.791015625},{"lat":"81.138459095287","lng":"-48.363281562924"}]','distance' => '6','created' => '2014-05-10 17:33:29','updated' => '2014-06-12 22:39:04','deleted' => NULL,'markerStart_id' => '16','markerEnd_id' => '18','routeType_id' => '2'),
            array('id' => '10','map_id' => '1','faction_id' => '2','name' => 'Route des Cendres','coordinates' => '[{"lat":"84.186870998601","lng":"-39.213866963983"},{"lat":84.258386319559,"lng":-34.7607421875},{"lat":84.367254322484,"lng":-33.4423828125},{"lat":84.401655629847,"lng":-26.9384765625},{"lat":84.336980376396,"lng":-22.8076171875},{"lat":84.223107574382,"lng":-19.775390625},{"lat":84.011439006528,"lng":-18.5888671875},{"lat":"83.847239701688","lng":"-16.992187052965"}]','distance' => '22','created' => '2014-05-10 17:54:32','updated' => '2014-06-12 18:36:41','deleted' => NULL,'markerStart_id' => '19','markerEnd_id' => '21','routeType_id' => '2'),
            array('id' => '11','map_id' => '1','faction_id' => '11','name' => 'Route royale','coordinates' => '[{"lat":"76.689905821569","lng":"-61.2158203125"},{"lat":76.880774572502,"lng":-59.94140625},{"lat":76.999935118116,"lng":-59.3701171875},{"lat":77.118031812032,"lng":-59.0185546875},{"lat":77.244779807653,"lng":-58.4912109375},{"lat":77.331809185214,"lng":-57.8759765625},{"lat":"77.513624042495","lng":"-56.337890625"}]','distance' => '5','created' => '2014-05-23 21:21:02','updated' => '2014-06-12 22:39:04','deleted' => NULL,'markerStart_id' => '13','markerEnd_id' => '33','routeType_id' => '2'),
            array('id' => '12','map_id' => '1','faction_id' => '4','name' => 'Chemin','coordinates' => '[{"lat":"81.138459095287","lng":"-48.363281562924"},{"lat":80.774715722952,"lng":-47.6806640625},{"lat":80.928425692823,"lng":-46.4501953125},{"lat":80.816890886409,"lng":-46.5380859375},{"lat":"80.725268622776","lng":"-45.0439453125"}]','distance' => '4','created' => '2014-05-23 21:21:02','updated' => '2014-06-12 22:42:23','deleted' => NULL,'markerStart_id' => '18','markerEnd_id' => '23','routeType_id' => '1'),
            array('id' => '13','map_id' => '1','faction_id' => '2','name' => 'Route de la mer','coordinates' => '[{"lat":"84.186870998601","lng":"-39.213866963983"},{"lat":84.006852447084,"lng":-38.1005859375},{"lat":83.92369331797,"lng":-37.6171875},{"lat":83.839384686775,"lng":-37.529296875},{"lat":83.796794408325,"lng":-37.6171875},{"lat":83.758690233955,"lng":-37.79296875},{"lat":83.701096416017,"lng":-38.583984375},{"lat":83.672101317305,"lng":-38.759765625},{"lat":83.628359247711,"lng":-38.84765625},{"lat":83.579403700731,"lng":-38.9794921875},{"lat":83.475374499592,"lng":-38.8916015625},{"lat":83.430278395539,"lng":-38.7158203125},{"lat":83.410136200862,"lng":-38.14453125},{"lat":83.318732821632,"lng":-36.8701171875},{"lat":83.24160006732,"lng":-36.474609375},{"lat":83.036881985524,"lng":-36.298828125},{"lat":"82.580433663115","lng":"-36.826171875"}]','distance' => '7','created' => '2014-06-12 18:36:41','updated' => '2015-01-26 17:08:45','deleted' => NULL,'markerStart_id' => '19','markerEnd_id' => '22','routeType_id' => '2'),
            array('id' => '14','map_id' => '1','faction_id' => '1','name' => 'Route de Farl','coordinates' => '[{"lat":"83.978491200531","lng":"-52.309570088983"},{"lat":83.886365657805,"lng":-47.2412109375},{"lat":83.876998103924,"lng":-46.0546875},{"lat":83.872308966366,"lng":-44.7802734375},{"lat":83.872308966366,"lng":-42.8466796875},{"lat":83.900390225918,"lng":-41.220703125},{"lat":83.919039805857,"lng":-40.5615234375},{"lat":83.983867097691,"lng":-39.7705078125},{"lat":84.020601636108,"lng":-39.375},{"lat":"84.186870998601","lng":"-39.213866963983"}]','distance' => '13','created' => '2014-06-12 19:03:53','updated' => '2015-01-26 17:09:22','deleted' => NULL,'markerStart_id' => '20','markerEnd_id' => '19','routeType_id' => '1'),
            array('id' => '15','map_id' => '1','faction_id' => '1','name' => 'Voie sainte','coordinates' => '[{"lat":81.485801987835,"lng":-112.7197265625},{"lat":83.978491200531,"lng":-52.309570088983}]','distance' => '60','created' => '2014-06-12 19:03:53','updated' => '2015-01-22 21:09:35','deleted' => '2015-01-22 21:10:45','markerStart_id' => '9','markerEnd_id' => '20','routeType_id' => '2'),
            array('id' => '16','map_id' => '1','faction_id' => '4','name' => 'Route du Dorchwald','coordinates' => '[{"lat":"82.956511348774","lng":"-98.26171875"},{"lat":82.818673238193,"lng":-93.890625312924},{"lat":82.878850596244,"lng":-90.550781562924},{"lat":82.796665366646,"lng":-86.947265937924},{"lat":82.69865866057,"lng":-84.2431640625},{"lat":82.847913026012,"lng":-80.947265625},{"lat":83.015539472979,"lng":-79.365234375},{"lat":83.142624984997,"lng":-77.1240234375},{"lat":83.231248954109,"lng":-73.6962890625},{"lat":83.405091053034,"lng":-71.279296875},{"lat":83.405091053034,"lng":-70.13671875},{"lat":83.515201107958,"lng":-66.09375},{"lat":83.505267206927,"lng":-64.0283203125},{"lat":83.584316063893,"lng":-62.40234375},{"lat":83.701096416017,"lng":-61.7431640625},{"lat":83.782532573607,"lng":-59.8095703125},{"lat":83.815759510335,"lng":-58.6669921875},{"lat":"83.7491278189","lng":"-57.48046875"}]','distance' => '41','created' => '2014-06-12 19:03:53','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerStart_id' => '26','markerEnd_id' => '27','routeType_id' => '1'),
            array('id' => '17','map_id' => '1','faction_id' => '4','name' => 'Chemin des Hauts-Vents','coordinates' => '[{"lat":"82.213224838025","lng":"-50.639648213983"},{"lat":82.12842074307,"lng":-51.571289375424},{"lat":82.055869117726,"lng":-52.977539375424},{"lat":81.939634609206,"lng":-52.845703437924},{"lat":81.827959832583,"lng":-52.625976875424},{"lat":"81.433593340862","lng":"-51.85546875"}]','distance' => '4','created' => '2014-06-12 19:27:54','updated' => '2014-06-12 22:41:07','deleted' => NULL,'markerStart_id' => '31','markerEnd_id' => '32','routeType_id' => '1'),
            array('id' => '18','map_id' => '1','faction_id' => NULL,'name' => 'Route de Promesse','coordinates' => '[{"lat":"80.558540053033","lng":"-57.372070625424"},{"lat":80.618424196855,"lng":-55.986328125},{"lat":80.800512231891,"lng":-54.076172187924},{"lat":80.835574027072,"lng":-52.933594062924},{"lat":80.800512231891,"lng":-51.922851875424},{"lat":80.926115844166,"lng":-50.560547187924},{"lat":80.988278462845,"lng":-49.330078437924},{"lat":80.953795998359,"lng":-47.572265937924},{"lat":81.029485388345,"lng":-46.649414375424},{"lat":80.988278462845,"lng":-44.144531562924},{"lat":"80.983688308259","lng":"-42.5390625"}]','distance' => '15','created' => '2014-06-12 20:15:00','updated' => '2014-06-12 22:35:09','deleted' => NULL,'markerStart_id' => '38','markerEnd_id' => '16','routeType_id' => '1'),
            array('id' => '21','map_id' => '1','faction_id' => NULL,'name' => '','coordinates' => '[{"lat":"81.485801987835","lng":"-112.7197265625"},{"lat":81.886055752609,"lng":-110.63232421875},{"lat":81.984695891072,"lng":-110.01708984375},{"lat":82.02747547132,"lng":-109.13818359375},{"lat":82.082144612986,"lng":-108.21533203125},{"lat":82.094242636306,"lng":-107.60009765625},{"lat":82.142451324956,"lng":-105.44677734375},{"lat":82.261698736832,"lng":-103.95263671875},{"lat":82.460305225036,"lng":-103.46923828125},{"lat":82.631332853693,"lng":-103.07373046875},{"lat":82.720964361268,"lng":-101.49169921875},{"lat":82.759836367778,"lng":-100.5908203125},{"lat":82.765372630274,"lng":-99.052734375},{"lat":"82.956511348774","lng":"-98.26171875"}]','distance' => '15','created' => '2014-06-12 22:14:12','updated' => '2015-01-26 17:09:31','deleted' => NULL,'markerStart_id' => '9','markerEnd_id' => '26','routeType_id' => '1'),
            array('id' => '23','map_id' => '1','faction_id' => NULL,'name' => 'Voie Sainte vers Gouvran','coordinates' => '[{"lat":"82.956511348774","lng":"-98.26171875"},{"lat":83.174035131731,"lng":-94.3505859375},{"lat":83.272558965094,"lng":-90},{"lat":83.231248954109,"lng":-87.626953125},{"lat":83.369667183848,"lng":-85.6494140625},{"lat":83.628359247711,"lng":-80.9033203125},{"lat":83.820491754431,"lng":-79.7607421875},{"lat":"84.029750297517","lng":"-77.6953125"}]','distance' => '21','created' => '2014-06-12 22:15:59','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerStart_id' => '26','markerEnd_id' => '25','routeType_id' => '1'),
            array('id' => '24','map_id' => '1','faction_id' => NULL,'name' => 'Voie Sainte vers Fionnfuar','coordinates' => '[{"lat":"84.029750297517","lng":"-77.6953125"},{"lat":84.29781830829,"lng":-76.6845703125},{"lat":84.452865291844,"lng":-74.20166015625},{"lat":84.553887899844,"lng":-70.68603515625},{"lat":84.64897950778,"lng":-68.57666015625},{"lat":84.653076161019,"lng":-66.51123046875},{"lat":84.640776810146,"lng":-64.35791015625},{"lat":84.599574881454,"lng":-61.58935546875},{"lat":84.5497154787,"lng":-59.39208984375},{"lat":84.474064584592,"lng":-58.46923828125},{"lat":84.310902231579,"lng":-57.23876953125},{"lat":84.133962727433,"lng":-56.57958984375},{"lat":84.057112683177,"lng":-55.48095703125},{"lat":84.038885011816,"lng":-54.82177734375},{"lat":"83.978491200531","lng":"-52.309570088983"}]','distance' => '25','created' => '2014-06-12 22:17:07','updated' => '2014-06-30 17:58:18','deleted' => NULL,'markerStart_id' => '25','markerEnd_id' => '20','routeType_id' => '1'),
            array('id' => '25','map_id' => '1','faction_id' => NULL,'name' => 'Chemin des hauts-vents moitié','coordinates' => '[{"lat":"81.433593340862","lng":"-51.85546875"},{"lat":81.354684022975,"lng":-51.13037109375},{"lat":81.314959278962,"lng":-50.73486328125},{"lat":81.328220945729,"lng":-50.42724609375},{"lat":81.261711062141,"lng":-49.63623046875},{"lat":81.17449100426,"lng":-49.63623046875},{"lat":81.17449100426,"lng":-49.10888671875},{"lat":"81.138459095287","lng":"-48.363281562924"}]','distance' => '4','created' => '2014-06-12 22:40:17','updated' => '2014-06-12 22:41:07','deleted' => NULL,'markerStart_id' => '32','markerEnd_id' => '18','routeType_id' => '1'),
            array('id' => '26','map_id' => '1','faction_id' => NULL,'name' => 'Route royale vers Afalinn','coordinates' => '[{"lat":"77.513624042495","lng":"-56.337890625"},{"lat":77.664737637886,"lng":-54.90966796875},{"lat":77.952413847158,"lng":-53.19580078125},{"lat":78.089229210932,"lng":-52.71240234375},{"lat":78.55176918838,"lng":-52.27294921875},{"lat":78.946137317901,"lng":-51.30615234375},{"lat":79.138260331684,"lng":-49.68017578125},{"lat":79.408165212624,"lng":-48.53759765625},{"lat":79.943594769294,"lng":-48.18603515625},{"lat":80.297927149974,"lng":-47.96630859375},{"lat":80.639890227043,"lng":-46.95556640625},{"lat":80.675558819735,"lng":-46.25244140625},{"lat":"80.725268622776","lng":"-45.0439453125"}]','distance' => '12','created' => '2014-06-12 22:41:07','updated' => '2014-06-12 22:41:07','deleted' => NULL,'markerStart_id' => '33','markerEnd_id' => '23','routeType_id' => '1'),
            array('id' => '27','map_id' => '1','faction_id' => '9','name' => 'Route de la Côte','coordinates' => '[{"lat":"75.464105104918","lng":"-53.19580078125"},{"lat":75.635902142752,"lng":-52.098633125424},{"lat":75.635902142752,"lng":-49.681640937924},{"lat":75.614081772112,"lng":-47.220703437924},{"lat":75.559388793102,"lng":-45.375000312924},{"lat":75.830832793815,"lng":-44.891601875424},{"lat":76.033781671679,"lng":-42.474609687924},{"lat":76.327680515889,"lng":-42.914062812924},{"lat":76.767249101994,"lng":-42.123047187924},{"lat":77.241545279482,"lng":-42.123047187924},{"lat":77.519956712852,"lng":-41.507812812924},{"lat":77.773788236146,"lng":-40.936523750424},{"lat":77.96769174439,"lng":-40.365234687924},{"lat":78.230490435865,"lng":-40.584961250424},{"lat":78.557582691377,"lng":-41.200195625424},{"lat":78.951753091746,"lng":-41.244140937924},{"lat":79.13549968038,"lng":-41.683594062924},{"lat":79.56585345765,"lng":-41.947265937924},{"lat":79.715990687218,"lng":-41.200195625424},{"lat":79.979342025766,"lng":-39.969726875424},{"lat":80.183709607243,"lng":-38.739258125424},{"lat":80.23601666825,"lng":-37.420898750424},{"lat":80.493439642424,"lng":-36.322265937924},{"lat":80.673185146707,"lng":-37.201172187924},{"lat":80.821565235526,"lng":-38.563476875424},{"lat":80.856547476297,"lng":-40.892578437924},{"lat":80.960702943115,"lng":-41.683594062924},{"lat":"80.983688308259","lng":"-42.5390625"}]','distance' => '29','created' => '2014-06-13 14:11:40','updated' => '2014-06-13 14:11:40','deleted' => NULL,'markerStart_id' => '14','markerEnd_id' => '16','routeType_id' => '1'),
            array('id' => '28','map_id' => '1','faction_id' => '10','name' => 'Route de l\'Ouest','coordinates' => '[{"lat":"76.689905821569","lng":"-61.2158203125"},{"lat":76.58835594878,"lng":-63.017578125},{"lat":76.557742938966,"lng":-63.5009765625},{"lat":76.486045606482,"lng":-63.8525390625},{"lat":76.382969428475,"lng":-64.3798828125},{"lat":76.299953458933,"lng":-64.6875},{"lat":76.195485157143,"lng":-64.951171875},{"lat":75.973552953433,"lng":-65.302734375},{"lat":75.823659506243,"lng":-65.654296875},{"lat":75.780545353239,"lng":-66.09375},{"lat":75.791335916047,"lng":-66.4453125},{"lat":75.866645605399,"lng":-66.9287109375},{"lat":75.866645605399,"lng":-67.4560546875},{"lat":75.812892986971,"lng":-67.8955078125},{"lat":75.62863223279,"lng":-68.9501953125},{"lat":75.584937408692,"lng":-69.43359375},{"lat":75.541112557811,"lng":-70.5322265625},{"lat":75.563041259158,"lng":-72.0263671875},{"lat":75.264238752242,"lng":-72.158203125},{"lat":75.106931558628,"lng":-73.212890625},{"lat":74.993565570822,"lng":-73.30078125},{"lat":74.95939165895,"lng":-74.1357421875},{"lat":74.683250300519,"lng":-74.3994140625},{"lat":74.437571847973,"lng":-72.158203125},{"lat":74.307353414862,"lng":-70.751953125},{"lat":74.067866249523,"lng":-70.83984375},{"lat":74.067866249523,"lng":-72.0703125},{"lat":73.958938873775,"lng":-73.388671875},{"lat":73.726594702123,"lng":-74.53125},{"lat":"73.669028766658","lng":"-75.896485000849"}]','distance' => '23','created' => '2014-06-13 14:16:24','updated' => '2015-01-26 17:10:34','deleted' => NULL,'markerStart_id' => '13','markerEnd_id' => '36','routeType_id' => '1'),
            array('id' => '29','map_id' => '1','faction_id' => '9','name' => 'Route des Hilderin','coordinates' => '[{"lat":"70.863889877509","lng":"-100.59375062585"},{"lat":70.407347676068,"lng":-101.337890625},{"lat":69.945375151289,"lng":-100.283203125},{"lat":69.748551129122,"lng":-97.7783203125},{"lat":69.748551129122,"lng":-96.0205078125},{"lat":69.503765195637,"lng":-94.74609375},{"lat":68.84766505841,"lng":-93.8232421875},{"lat":68.768235051223,"lng":-92.5048828125},{"lat":68.496040228395,"lng":-91.494140625},{"lat":67.908619182153,"lng":-90.5712890625},{"lat":67.525373478753,"lng":-91.1865234375},{"lat":66.930060258624,"lng":-91.318359375},{"lat":66.548263462174,"lng":-90.3076171875},{"lat":66.425537171578,"lng":-89.208984375},{"lat":66.319861446681,"lng":-86.9677734375},{"lat":65.982270029809,"lng":-85.25390625},{"lat":65.512962553295,"lng":-84.5947265625},{"lat":65.164578884019,"lng":-83.935546875},{"lat":64.504338678449,"lng":-82.245117500424},{"lat":64.110602219546,"lng":-83.49609375},{"lat":63.568120480921,"lng":-83.8916015625},{"lat":62.532594345486,"lng":-84.0673828125},{"lat":61.480759500076,"lng":-82.0458984375},{"lat":"60.75915950227","lng":"-78.9697265625"}]','distance' => '32','created' => '2014-06-13 18:04:30','updated' => '2014-06-13 18:09:42','deleted' => NULL,'markerStart_id' => '44','markerEnd_id' => '8','routeType_id' => '2'),
            array('id' => '30','map_id' => '1','faction_id' => '4','name' => 'Route du Grand Est','coordinates' => '[{"lat":"83.847239701688","lng":"-16.992187052965"},{"lat":83.791251991326,"lng":-14.165038838983},{"lat":83.81497042802,"lng":-13.242187276483},{"lat":83.824432511579,"lng":-12.407226338983},{"lat":83.776977464063,"lng":-10.825195088983},{"lat":83.690641234829,"lng":-10.341796651483},{"lat":83.680974981204,"lng":-9.3749997764826},{"lat":83.709929583825,"lng":-8.4960935264826},{"lat":83.680974981204,"lng":-7.5732419639826},{"lat":83.627546351144,"lng":-7.3974607139826},{"lat":83.573667851226,"lng":-6.9580075889826},{"lat":83.573667851226,"lng":-5.8154294639826},{"lat":83.549027896247,"lng":-5.0683591514826},{"lat":83.499465410131,"lng":-5.0683591514826},{"lat":83.429440336925,"lng":-5.0683591514826},{"lat":83.404249795605,"lng":-4.7607419639826},{"lat":83.404249795605,"lng":-4.1455075889826},{"lat":83.389089342847,"lng":-3.5302732139826},{"lat":83.33320361535,"lng":-2.2119138389826},{"lat":83.27684760655,"lng":-2.1240232139826},{"lat":83.183604058477,"lng":-1.9482419639826},{"lat":83.199233555801,"lng":-1.2011716514826},{"lat":83.183604058477,"lng":-0.71777321398258},{"lat":83.125989430073,"lng":-0.23437477648258},{"lat":82.987875668356,"lng":0.33691428601742},{"lat":82.906942250179,"lng":1.0839845985174},{"lat":82.906942250179,"lng":2.7539064735174},{"lat":82.830566172069,"lng":2.8857424110174},{"lat":82.753372040416,"lng":2.7978517860174},{"lat":82.664137415235,"lng":3.1054689735174},{"lat":82.52251575544,"lng":3.9843752235174},{"lat":82.459344101811,"lng":4.3798830360174},{"lat":"82.506294787715","lng":"5.3144524991512"}]','distance' => '23','created' => '2014-06-15 13:41:21','updated' => '2014-06-15 13:41:21','deleted' => NULL,'markerStart_id' => '21','markerEnd_id' => '39','routeType_id' => '1'),
            array('id' => '32','map_id' => '1','faction_id' => '4','name' => 'Piste de l\'ours blanc','coordinates' => '[{"lat":"82.506294787715","lng":"5.3144524991512"},{"lat":82.425629000297,"lng":10.2392578125},{"lat":82.118383606913,"lng":12.5244140625},{"lat":81.984695891072,"lng":14.5458984375},{"lat":81.917009639208,"lng":16.6552734375},{"lat":81.786209927192,"lng":17.666015625},{"lat":81.65330835588,"lng":17.666015625},{"lat":81.485801987835,"lng":18.984375},{"lat":81.275053408543,"lng":20.126953125},{"lat":81.031769139773,"lng":19.7314453125},{"lat":80.851890790865,"lng":20.91796875},{"lat":80.532071122327,"lng":21.533203125},{"lat":80.320119629632,"lng":22.236328125},{"lat":80.253390906524,"lng":25.048828125},{"lat":80.020041963484,"lng":26.3671875},{"lat":"79.22897540022","lng":"25.0048828125"}]','distance' => '24','created' => '2014-06-15 13:47:26','updated' => '2014-06-17 17:14:33','deleted' => NULL,'markerStart_id' => '39','markerEnd_id' => '40','routeType_id' => '3')
        );

        foreach ($routes as $route) {
            $faction = $route['faction_id'] ? 'faction'.$route['faction_id'] : null;
            $map = 'map'.$route['map_id'];
            $routeType = 'routeType'.$route['routeType_id'];
            $markerStart = 'marker'.$route['markerStart_id'];
            $markerEnd = 'marker'.$route['markerEnd_id'];
            $this->fixtureObject($repo, $route['id'], $$map, $faction ? $$faction : null, $route['name'], $route['coordinates'], $route['created'], $route['updated'], $route['deleted'], $$markerStart, $$markerEnd, $$routeType);
        }

        $this->manager->flush();
    }

    public function fixtureObject(EntityRepository $repo, $id, $map, $faction, $name, $latLngs, $created, $updated, $deleted, $markerStart, $markerEnd, $routeType)
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
            $obj = new Routes();
            $obj->setId($id)
                ->setName($name)
                ->setCoordinates($latLngs)
                ->setFaction($faction)
                ->setMap($map)
                ->setMarkerStart($markerStart)
                ->setMarkerEnd($markerEnd)
                ->setRouteType($routeType)
                ->setCreated($created ? new \Datetime($created) : new \Datetime())
                ->setUpdated($updated ? new \Datetime($updated) : null)
                ->setDeleted($deleted ? new \Datetime($deleted) : null)
                ->refresh()
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
            $this->addReference('esterenmaps-Routes-'.$id, $obj);
        }
    }
}