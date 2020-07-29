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
