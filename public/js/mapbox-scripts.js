/**
 * MAPBOX para las ubicaciones*/

    // TO MAKE THE MAP APPEAR YOU MUST
    // ADD YOUR ACCESS TOKEN FROM
    // https://account.mapbox.com
var user_location = [-86.56309459414412, 14.028024106451483];
var saved_markers = JSON.parse(document.getElementById("saved_markers").value);
console.log(saved_markers);
mapboxgl.accessToken = 'pk.eyJ1Ijoib2N0YXZpb2dhbWVybzI3IiwiYSI6ImNrZGI0bHd4bjBzNnAyenFyOXdkdTYxYWwifQ.xq8Ce1UW8xaePtTaNK4IKA';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/satellite-streets-v11', // stylesheet location
    center: user_location, // starting position [lng, lat]
    zoom: 14, // starting zoom,

});
map.addControl(new mapboxgl.GeolocateControl({
    positionOptions: {
        enableHighAccuracy: true
    },
    trackUserLocation: true
}));
//  geocoder here
var geocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    // limit results to Australia
    //country: 'IN',
});

map.addControl(
    new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        country: "HN"

    })
);
var nav = new mapboxgl.NavigationControl();
map.addControl(nav, 'top-left');
var scale = new mapboxgl.ScaleControl({
    maxWidth: 80,
    unit: 'imperial',
});
map.addControl(scale);
scale.setUnit('metric');

// After the map style has loaded on the page, add a source layer and default
// styling for a single point.
map.on('load', function () {
    addMarker(user_location, 'load');
    add_markers(saved_markers);
    geocoder.on('result', function (ev) {
        console.log(ev.result.center);
    });
});
map.on('click', function (e) {
    marker.remove();
    addMarker(e.lngLat, 'click');
    document.getElementById("nuevaUbicacionBtn").removeAttribute("disabled")
    document.getElementById("latitud").value = e.lngLat.lat;
    document.getElementById("longitud").value = e.lngLat.lng;
    console.log(e);

});

function addMarker(ltlng, event) {

    if (event === 'click') {
        user_location = ltlng;
    }
    marker = new mapboxgl.Marker({draggable: true, color: "#d02922"})
        .setLngLat(user_location)
        .addTo(map)
        .on('dragend', onDragEnd);
}
var markerHeight = 50, markerRadius = 10, linearOffset = 25;
var popupOffsets = {
    'top': [0, 0],
    'top-left': [0,0],
    'top-right': [0,0],
    'bottom': [0, -markerHeight],
    'bottom-left': [linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
    'bottom-right': [-linearOffset, (markerHeight - markerRadius + linearOffset) * -1],
    'left': [markerRadius, (markerHeight - markerRadius) * -1],
    'right': [-markerRadius, (markerHeight - markerRadius) * -1]
};

function add_markers(coordinates) {

    //Crea los puntos de ubicacion de la empresa que tenga registrados en la base de datos
    var geojson = (saved_markers == coordinates ? saved_markers : '');

    console.log(geojson);
    // add markers to map
    geojson.forEach(function (marker) {
        console.log(marker.longitud);
        // make a marker for each feature and add to the map
        var lnglat= [marker.longitud,marker.latitud];
        /**establece el popup con la descripcion de la empresa*/
        var popup = new mapboxgl.Popup({offset: popupOffsets, className: 'my-class'})
            .setLngLat(lnglat)
            .setHTML("<h6> <span " +
                "style='color: red' class='fas fa-map-marker-alt'>" +
                "</span> "+marker.descripcion+"</h6>")
            .setMaxWidth("150px")
            .addTo(map);
        new mapboxgl.Marker()
            .setLngLat(lnglat)
            .addTo(map);
    });

}

function onDragEnd() {
    var lngLat = marker.getLngLat();
    document.getElementById("nuevaUbicacionBtn").removeAttribute("disabled")
    document.getElementById("latitud").value = lngLat.lat;
    document.getElementById("longitud").value = lngLat.lng;
    console.log('lng: ' + lngLat.lng + '<br />lat: ' + lngLat.lat);
}


