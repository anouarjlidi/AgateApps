/**
 * This script is here to transform latlng to x,y when Penrose projection is activated.
 */

// Whole update script
var map = document.map;
var leafletMap = map._map;
var crs = leafletMap.options.crs;
var markers = map._markers;
var polylines = map._polylines;
var polygons = map._polygons;
var i, l, marker, polyline, polygon, latlng, latlngs, list, point;
var transformation = new L.Transformation(0.03128, 0, 0.03128, 0);

for (i in markers) {
    if (!markers.hasOwnProperty(i)) { continue; }
    marker = markers[i];
    point = leafletMap.project(marker.getLatLng(), leafletMap.getMaxZoom());// TODO: test with 0 or 1
    point = transformation._transform(point);
    marker._latlng = L.latLng(point.x, point.y);
    //marker._updateEM();
}

for (i in polylines) {
    if (!polylines.hasOwnProperty(i)) { continue; }
    polyline = polylines[i];
    latlngs = [];
    for (list = polyline.getLatLngs(), i = 0, l = list.length; i < l; i++) {
        latlng = list[i];
        point = leafletMap.project(latlng, leafletMap.getMaxZoom());
        point = transformation._transform(point);
        list[i] = L.latLng(point.x, point.y);
    }
    polyline._latlngs = list;
    //polyline._updateEM();
}

for (i in polygons) {
    if (!polygons.hasOwnProperty(i)) { continue; }
    polygon = polygons[i];
    latlngs = [];
    for (list = polygon.getLatLngs(), i = 0, l = list.length; i < l; i++) {
        latlng = list[i];
        point = leafletMap.project(latlng, leafletMap.getMaxZoom());
        point = transformation._transform(point);
        list[i] = L.latLng(point.x, point.y);
    }
    polygon._latlngs = list;
    //polygon._updateEM();
}


// Single test
//marker = markers[68];
//latlng = L.latLng([81.28171699935, -130.25390625]);
//point = leafletMap.project(latlng);
//latlng = L.latLng(point.x, point.y);
//marker._latlng = latlng;
//marker._updateEM();
