/**
 * Here we absolutely need the canvas to be infinite.
 * This is why we create a specific CRS to handle latitudes and longitudes beyond -90/+90 and -180/+180 limits.
 *
 * Check this link for more info:
 * @see https://github.com/Leaflet/Leaflet/issues/210#issuecomment-3344944
 */

L.Projection.NoWrap = {
    project: function (latlng) {
        return new L.Point(latlng.lng, latlng.lat);
    },
    unproject: function (point, unbounded) {
        return new L.LatLng(point.x, point.y, true);
    }
};

L.CRS.Direct = L.Util.extend({}, L.CRS.Simple, {
    code: 'Direct',

    projection: L.Projection.NoWrap,
    transformation: new L.Transformation(1, 0, 1, 0)
});
