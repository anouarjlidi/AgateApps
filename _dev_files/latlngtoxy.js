/**
 * This script is here to transform latlng to x,y when Penrose projection is activated.
 */

// Whole update script
var map = document.map;
var leafletMap = map._map;
var crs = leafletMap.options.crs;
var markers = map._markers;
var i, marker, latlng, point;

for (i in markers) {
    if (!markers.hasOwnProperty(i)) { continue; }
    marker = markers[i];
    point = leafletMap.project(marker.getLatLng(), leafletMap.getMaxZoom());// TODO: test with 0 or 1
    marker._latlng = L.latLng(point.y, point.x);
    //marker._updateEM();
}


// Single test
marker = markers[68];
latlng = L.latLng([81.28171699935, -130.25390625]);
point = leafletMap.project(latlng);
latlng = L.latLng(point.y, point.x);
marker._latlng = latlng;
//marker._updateEM();
