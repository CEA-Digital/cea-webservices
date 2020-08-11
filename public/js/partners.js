$(document).ready(function () {
    $(".select2TipoCategoria").select2({
        theme: "classic",
        placeholder: "Seleccione una opción"
    });
});
/**------------------PERMITE VER LA IMG SELECCIONA EN UN INPUT EN POPOVER-------------------------------------*/
$(document).on('click', '#close-preview', function () {
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
            $('.image-preview').popover('show');
        },
        function () {
            $('.image-preview').popover('hide');
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
    $('.image-preview').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Vista Previa </strong>" + $(closebtn)[0].outerHTML,
        content: "No hay una imagen seleccionada",
        placement: 'auto',
        sanitize: false
    });
    // Clear event
    $('.image-preview-clear').click(function () {
        $('.image-preview').attr("data-content", "").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Seleccionar");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function () {
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
            $(".image-preview-input-title").text("Cambiar");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            $("#imgVistaPreviaEditarCategoria").attr("src",e.target.result);
            img.attr('src', e.target.result);
            img.attr("width", 250)
            $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show").attr("width", 250).attr("height", 250);
        }
        reader.readAsDataURL(file);
    });
});
$('#modalBorrarPartners').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idPartners = button.data("id_partners");
    var nombrePartners = button.data("nombre");
     var modal = $(this);
    modal.find('.modal-body #nombrePartners').text(nombrePartners)
    modal.find('.modal-footer #nombre_hidden').val(nombrePartners)

    modal.find('.modal-footer #idPartners').val(idPartners);
});

$('#modalEditarPartners').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idPartners = button.data("id");
     var nombrePartners = button.data("nombre");
    var descripcion = button.data("descripcion");
     var img_url = button.data("img_url");


    var modal = $(this);
    modal.find('.modal-body #nombreEditarPartners').val(nombrePartners);
    modal.find('.modal-body #imgVistaPreviaEditarPartners').attr("src","storage/images/partners/"+img_url);
    modal.find('.modal-body #descripcionEditarPartners').val(descripcion);
    modal.find('.modal-footer #idPartners').val(idPartners);
});

/****---------------------------------------------------------------------*/







$('#modalVistaPreviaServicio').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/storage/images/servicio/"+src_imagen);

});





