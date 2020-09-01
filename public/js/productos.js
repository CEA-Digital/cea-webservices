$('#modalVistaPreviaProductos').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var src_imagen = button.data("src_img");

    var modal = $(this);
    modal.find('.modal-body #img').attr("src","/images/productos/"+src_imagen);
});
//Editar modal Producto
$('#modalEditarProducto').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var id_producto = button.data('id');
    var name = button.data('name');
    var unit_prince = button.data('unit_price');
    var lote_price = button.data('lote_price');
    var description = button.data('description');
    var disponible = button.data('disponible');
    var categoria = button.data('id_categoria');
    var empresa = button.data('id_empresa');
    var img_url = button.data('img_url');
    var id_marca = button.data('id_marca');



    var modal = $(this);
    modal.find('.modal-footer #id_producto').val(id_producto);
    modal.find('.modal-body #nombreEditarProducto').val(name);
    modal.find('.modal-body #precioUnitarioProducto').val(unit_prince);
    modal.find('.modal-body #precioLoteProducto').val(lote_price);
    modal.find('.modal-body #descripcionEditarProducto').val(description);
    modal.find('.modal-body #disponible').val(disponible).change();
    modal.find('.modal-body #tipoEditarCategoria').val(categoria).change();
    modal.find('.modal-body #empresa').val(empresa).change();
    modal.find('.modal-body #marca').val(id_marca).change();
    modal.find('.modal-body #imgVistaPreviaEditarCategoria').attr("src","/images/productos/"+img_url);
});
//Ver Producto
$('#modalVerProducto').on('show.bs.modal',function (e) {
    var button = $(e.relatedTarget);
    var name = button.data('name');
    var unit_prince = button.data('unit_price');
    var lote_price = button.data('lote_price');
    var description = button.data('description');
    var disponible = button.data('disponible');
    var categoria = button.data('id_categoria');
    var empresa = button.data('id_empresa');
    var img_url = button.data('img_url');
    var id_marca = button.data('id_marca');

    var modal = $(this);
    modal.find('.modal-body #nombreNuevoProducto').text(name);
    modal.find('.modal-body #precioUnitarioProducto').text(unit_prince);
    modal.find('.modal-body #precioLoteProducto').text(lote_price);
    if (description==null){
        modal.find('.modal-body #descripcionNuevaCategoria').val("Sin descripción");
    }else{
        modal.find('.modal-body #descripcionNuevaCategoria').val(description);
    }
    if (disponible==1){
        modal.find('.modal-body #disponible').text("Disponible");
    }else{
        modal.find('.modal-body #disponible').text("No Disponible");
    }
    modal.find('.modal-body #tipoNuevaCategoria').text(categoria);
    modal.find('.modal-body #empresa').text(empresa);
    modal.find('.modal-body #marca').text(id_marca);
    modal.find('.modal-body #imgVistaPreviaEditarCategoria').attr("src","/images/productos/"+img_url);
});

$('#modalBorrarProducto').on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget);
    var id = button.data('id');
    var name= button.data('name');

    var modal=$(this);
    modal.find('.modal-footer #id_producto').val(id);
    modal.find('.modal-body #nombreProducto').text(name);
});








