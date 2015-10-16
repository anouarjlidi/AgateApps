<?php

namespace EsterenMaps\MapsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * Class MapsController
 * @package EsterenMaps\MapsBundle\Controller
 * @Route(host="%esteren_domains.esteren_maps%")
 */
class MapsController extends Controller
{

    /**
     * @Route("/map-{nameSlug}")
     * @Method("GET")
     */
    public function viewAction(Maps $map) {

        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev\.php/~isUu', '', $tilesUrl);

        return $this->render('@EsterenMaps/Maps/view.html.twig', array(
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ));
    }

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $list = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAllRoot();
        /** @var Maps $map */
        $map = $list[0];

        $marker = $map->getMarkers()[0];

        $latlng = array((float) $marker->getLatitude(), (float) $marker->getLongitude());

        dump($latlng);

        $s = <<<JS

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

        return $this->render('@EsterenMaps/Maps/index.html.twig', array('list' => $list));
    }
}
