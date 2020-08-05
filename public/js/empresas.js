$(document).on('click', '#close-preview-profile', function () {
    $('.image-preview-profile').popover('hide');
    // Hover befor close the preview
    $('.image-preview-profile').hover(
        function () {
            $('.image-preview-profile').popover('show');
        },
        function () {
            $('.image-preview-profile').popover('hide');
        }
    );
});

$(function () {
    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: "x",
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class", "close pull-right");
    // Set the popover default content
    $('.image-preview-profile').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Vista Previa </strong>" + $(closebtn)[0].outerHTML,
        content: "No hay una imagen seleccionada",
        placement: 'auto',
        sanitize: false
    });
    // Clear event
    $('.image-preview-clear-profile').click(function () {
        $('.image-preview-profile').attr("data-content", "").popover('hide');
        $('.image-preview-filename-profile').val("");
        $('.image-preview-clear-profile').hide();
        $('.image-preview-input-profile input:file').val("");
        $(".image-preview-input-title-profile").text("Seleccionar");
    });
    // Create the preview image
    $(".image-preview-input-profile input:file").change(function () {
        var img = $('<img/>', {
            id: 'dynamic',
            width: 250,
            height: 200,
            objectFit: "contain"
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title-profile").text("Cambiar");
            $(".image-preview-clear-profile").show();
            $(".image-preview-filename-profile").val(file.name);
         //   $("#imgVistaPreviaEditarCategoria").attr("src",e.target.result);
            img.attr('src', e.target.result);
            img.attr("width", 250)
            $(".image-preview-profile").attr("data-content", $(img)[0].outerHTML).popover("show").attr("width", 250).attr("height", 250);
        }
        reader.readAsDataURL(file);
    });
});

/**CARGA EL INPUT PARA VARIOS ARCHIVOS**/
$("#imagenes_empresa").fileinput({
    theme: 'fa',
    language:"es",
    uploadUrl: "/image-view",
    uploadExtraData: function() {
        return {
            _token: $("input[name='_token']").val(),
        };
    },
    allowedFileExtensions: ["jpeg",'jpg', 'png', 'gif'],
    overwriteInitial: true,
    maxFileSize:10000,
    maxFilesNum: 10,
    slugCallback: function (filename) {
        return filename.replace('(', '_').replace(']', '_');
    }
});
$('#modalNuevaUbicacion').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var latitud = document.getElementById("latitud").value;
    var longitud = document.getElementById("longitud").value;

    var modal = $(this);
    modal.find('.modal-footer #latitud_modal').val(latitud);
    modal.find('.modal-footer #longitud_modal').val(longitud);
});
$('#modalEliminarUbicacion').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data("id");

    console.log(id);
    var modal = $(this);
    modal.find('.modal-footer #id_ubicacion').val(id);
});

$('#modalVistaPreviaImgEmpresa').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/empresas/"+src_imagen);

});



// TO MAKE THE MAP APPEAR YOU MUST
// ADD YOUR ACCESS TOKEN FROM
// https://account.mapbox.com
var user_location = [-86.56309459414412, 14.028024106451483];
var saved_markers = JSON.parse(document.getElementById("saved_markers").value);
console.log(saved_markers);
mapboxgl.accessToken = 'pk.eyJ1Ijoib2N0YXZpb2dhbWVybzI3IiwiYSI6ImNrZGI0bHd4bjBzNnAyenFyOXdkdTYxYWwifQ.xq8Ce1UW8xaePtTaNK4IKA';
var map = new mapboxgl.Map({
    container: 'direcciones_empresa',
    style: 'mapbox://styles/mapbox/satellite-streets-v11', // stylesheet location
    center: user_location, // starting position [lng, lat]
    zoom: 13, // starting zoom,

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



