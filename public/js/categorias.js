$(document).ready(function () {
    $(".select2TipoCategoria").select2({
        theme: "classic",
        placeholder: "Seleccione una opción"
    });
    $(".select2Empresa").select2({
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
$('#modalBorrarCategoria').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCategoria = button.data("id_categoria");
    var nombreCategoria = button.data("nombre");

    var modal = $(this);
    modal.find('.modal-body #nombreCategoriaBorrarModal').text(nombreCategoria)
    modal.find('.modal-footer #idCategoria').val(idCategoria);
});

$('#modalEditarCategoria').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCategoria = button.data("id");
    var nombreCategoria = button.data("nombre");
    var id_tipo_categoria= button.data("id_tipo_categoria");
    var descripcion = button.data("descripcion");
    var img_url = button.data("img_url");


    var modal = $(this);
    modal.find('.modal-body #nombreEditarCategoria').val(nombreCategoria);
    modal.find('.modal-body #imgVistaPreviaEditarCategoria').attr("src","/images/categorias/"+img_url);
    modal.find('.modal-body #descripcionEditarCategoria').val(descripcion);
    modal.find(".modal-body #tipoCategoriaEditar").val(id_tipo_categoria).change();
    modal.find('.modal-footer #idCategoria').val(idCategoria);
});

/****---------------------------------------------------------------------*/

$('#modalBorrarTipoCategoria').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCategoria = button.data("id_categoria");
    var nombreCategoria = button.data("nombre");

    var modal = $(this);
    modal.find('.modal-body #nombreTipoCategoriaBorrarModal').text(nombreCategoria)
    modal.find('.modal-footer #idCategoria').val(idCategoria);
});

$("#busquedaInput").on("keyup change", function () {
    var input = $("#busquedaInput");
    if(input.val()){
        $("#borrarBusqueda").classList.remove("hideClearSearch")
    }else{
        $("#borrarBusqueda").classList.add("hideClearSearch");
    }
});

$('#modalEditarTipoCategoria').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var idCategoria = button.data("id_categoria");
    var nombreCategoria = button.data("nombre");
    var src_img= button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #nombre_categoria').val(nombreCategoria)
    modal.find('.modal-footer #id').val(idCategoria);
    modal.find('.modal-body #imgVistaPreviaEditarCategoria').attr("src","/images/categorias/tipos/"+src_img);

});

$('#modalVistaPrevia').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/categorias/"+src_imagen);

});

/**------------------PERMITE VER LA IMG SELECCIONA EN UN INPUT EN POPOVER-------------------------------------*/
$(document).on('click', '#close-preview', function () {
    $('.image-preview-tipo-categoria').popover('hide');
    // Hover befor close the preview
    $('.image-preview-tipo-categoria').hover(
        function () {
            $('.image-preview-tipo-categoria').popover('show');
        },
        function () {
            $('.image-preview-tipo-categoria').popover('hide');
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
    $('.image-preview-tipo-categoria').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Vista Previa </strong>" + $(closebtn)[0].outerHTML,
        content: "No hay una imagen seleccionada",
        placement: 'auto',
        sanitize: false
    });
    // Clear event
    $('.image-preview-clear-tipo-categoria').click(function () {
        $('.image-preview-tipo-categoria').attr("data-content", "").popover('hide');
        $('.image-preview-filename-tipo-categoria').val("");
        $('.image-preview-clear-tipo-categoria').hide();
        $('.image-preview-input-tipo-categoria input:file').val("");
        $(".image-preview-input-title-tipo-categoria").text("Seleccionar");
    });
    // Create the preview image
    $(".image-preview-input-tipo-categoria input:file").change(function () {
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
            $(".image-preview-input-title-tipo-categoria").text("Cambiar");
            $(".image-preview-clear-tipo-categoria").show();
            $(".image-preview-filename-tipo-categoria").val(file.name);
          //  $("#imgVistaPreviaEditarCategoria").attr("src",e.target.result);
            img.attr('src', e.target.result);
            img.attr("width", 250)
            $(".image-preview-tipo-categoria").attr("data-content", $(img)[0].outerHTML).popover("show").attr("width", 250).attr("height", 250);
        }
        reader.readAsDataURL(file);
    });
});
/** Modal vista previa tipo categora*/
$('#modalVistaPreviaTipoCategorias').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/categorias/tipos/"+src_imagen);

});
