<?php

namespace EsterenMaps\MapsBundle\Command;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeCoordinatesSystemCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('esterenmaps:map:change-coordinates')
            ->setDescription('Changes the coordinates system for a map.')
            ->setHelp('This allows you to switch from { latitude, longitude } coordinates system with Mercator Projection'
                      ."\n".'(which is limited in terms of minimum and maximum latitude and longitude) to a classic and'
                      ."\n".'infinite { x, y } canvas that will allow both negative and positive coordinates.'
                      ."\n\n".'<info>Be very careful</info> because it can change a lot of things, and can also change the map representation!')
            ->addArgument('system', InputArgument::REQUIRED, 'The system you want to use. Can be one of "latlng" or "xy".')
            ->addArgument('id', InputArgument::OPTIONAL, 'The ID of the map to manage.', null)
            ->addOption('--force', null, InputOption::VALUE_NONE, 'By default, this command executes as dry run. This option will update the whole database.')
        ;
    }

    /**
     * WIP
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        /** @var BaseEntityRepository $mapsRepo */
        $mapsRepo = $em->getRepository('EsterenMapsBundle:Maps');

        /** @var Maps $map */
        if ($input->getArgument('id')) {
            $map = $mapsRepo->find($input->getArgument('id'));
        } else {
            $maps = $mapsRepo->findAllRoot('id');

            if (!count($maps)) {
                $output->writeln('<comment>There is no map in the database.</comment>');
                return 1;
            }

            do {
                $id = $dialog->select(
                    $output,
                    'Select a map:',
                    $maps,
                    false,
                    false,
                    'Invalid id: "%s"'
                );
                $map = isset($maps[$id]) ? $maps[$id] : null;
            } while (!$map);
        }

        $output->writeln('Taking care of map <info>'.$map.'</info>');

        $marker = $map->getMarkers()[0];

        dump($marker->getName());

        $xy = $this->transformLatLngToXY($map, (float) $marker->getLatitude(), (float) $marker->getLongitude());

        dump($marker->getLatitude(), $marker->getLongitude());

        dump($xy);

        $s = <<<JS


// Successful attempts:
m = document.map._markers[68]; // Le Roc
m.setLatLng([81.28171699935, -130.25390625]); // Before
m.setLatLng([-23.125, 35.4]); // After

m = document.map._markers[8]; // Osta-Baille
m.setLatLng([54.876606654109, -72.24609375]);
m.setLatLng([-81.12, 76.6]);


ratio1_lat = "2.196355146474609 * x + b";

// Test script
var map = document.map;
var leafletMap = map._map;
var crs = leafletMap.options.crs;
var markers = map._markers;
var i, marker;

for (i in markers) {
    if (!markers.hasOwnProperty(i)) { continue; }
    marker = markers[i];
    crs.latLngToPoint(marker.getLatLng());
}

var p = document.map._map.project(document.map._markers[68].getLatLng());
document.map.addMarker(p);

document.map._map.options.crs.latLngToPoint;
// Function()
// Code > EPSG:3857
// Projection: L.Projection.SphericalMercator

$.each(document.map._markers, function(i,e) {
    e._icon.style.outline="solid 3px red";
    e._icon.style.display="block";
    console.info(e);
});

var a = {

    final: function(latlng) {
        var zoom, d, max, lat, x, y, projectedPoint, scale;

        zoom = zoom === undefined ? this._zoom : zoom;

        d = Math.PI / 180;
        max = 85.0511287798;
        lat = Math.max(Math.min(max, latlng.lat), -max);
        x = latlng.lng * d;
        y = lat * d;

        y = Math.log(Math.tan((Math.PI / 4) + (y / 2)));

        projectedPoint = new L.Point(x, y, false);

        scale = 256 * Math.pow(2, zoom);
        scale = scale || 1;
        projectedPoint.x = scale * (this._a * projectedPoint.x + this._b);
        projectedPoint.y = scale * (this._c * projectedPoint.y + this._d);

        projectedPoint.x = Math.round(projectedPoint.x);
        projectedPoint.y = Math.round(projectedPoint.y);

        projectedPoint.x -= this._initialTopLeftPoint.x;
        projectedPoint.y -= this._initialTopLeftPoint.y;

        return projectedPoint;
    },

    latLngToLayerPoint: function (latlng) { // (LatLng)
        var projectedPoint = this.project(L.latLng(latlng))._round();
        return projectedPoint._subtract(this.getPixelOrigin());
    },


    project: function (latlng, zoom) { // (LatLng[, Number]) -> Point
        zoom = zoom === undefined ? this._zoom : zoom;
        return this.options.crs.latLngToPoint(L.latLng(latlng), zoom);
    },

    latLngToPoint: function (latlng, zoom) { // (LatLng, Number) -> Point
        var projectedPoint = this.projection.project(latlng),
            scale = this.scale(zoom);

        return this.transformation._transform(projectedPoint, scale);
    },

    scale: function (zoom) {
        return 256 * Math.pow(2, zoom);
    },

    MAX_LATITUDE: 85.0511287798,

    projectionProject: function (latlng) { // (LatLng) -> Point
        var d = L.LatLng.DEG_TO_RAD,
            max = this.MAX_LATITUDE,
            lat = Math.max(Math.min(max, latlng.lat), -max),
            x = latlng.lng * d,
            y = lat * d;

        y = Math.log(Math.tan((Math.PI / 4) + (y / 2)));

        return new L.Point(x, y);
    },

    transformation: new L.Transformation(0.5 / Math.PI, 0.5, -0.5 / Math.PI, 0.5),

    _transform: function (point, scale) {
        scale = scale || 1;
        point.x = scale * (this._a * point.x + this._b);
        point.y = scale * (this._c * point.y + this._d);
        return point;
    },

    z:0
};
JS;
        exit;

    }

    /**
     * Transforms a latlng point to x,y
     *
     * @param Maps  $map
     * @param float $lat
     * @param float $lng
     *
     * @return array
     */
    private function transformLatLngToXY(Maps $map, $lat, $lng)
    {
        $manager = $this->getContainer()->get('esteren_maps')->getTilesManager();

        $manager->setMap($map);

        $identification = $manager->identifyImage(1);

        $width = $identification->getGlobalWidth();
        $height = $identification->getGlobalHeight();

        return [
            'x' => ( $lng + 180 ) * ($width / 360),
            'y' => ( ( -1 * $lat ) + 90 ) * ( $height / 180 ),
        ];
    }
}
