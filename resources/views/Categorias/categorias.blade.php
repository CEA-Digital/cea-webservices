@extends("layouts.main")
@section("content")
    <div class="container-fluid">
        <h1 class="mt-4">Categorias
            <button class="btn btn-sm btn-warning"
                    data-toggle="modal" data-target="#modalNuevaCategoria"><span class="fas fa-plus"></span></button>
        </h1>
        <br>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
            </tr>
            </thead>
            <tbody>
            <tr></tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalNuevaCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevaCategoria">Nombre de categoria</label>
                            <input class="form-control" name="name" id="nombreNuevaCategoria" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="tipoNuevaCategoria">Seleccione el tipo de Categoria
                                <!---- Boton para crear un nuevo tipo de categoria- -->
                                <a class="btn btn-sm btn-outline-info"
                                   data-toggle="modal"
                                data-target="#modalNuevoTipoCategoria">
                                    <i class="fas fa-plus"></i></a></label>
                            <select name="id_categoria"
                                    class="form-control" id="tipoNuevaCategoria">
                                <option disabled selected value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcionNuevaCategoria">Descripción de nueva categoria:</label>
                            <textarea class="form-control" name="descripcion" id="descripcionNuevaCategoria"
                                      maxlength="192"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalNuevoTipoCategoria" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear nuevo tipo de categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreNuevoTipoCategoria">Ingrese el nombre:</label>
                            <input class="form-control" name="name" id="nombreNuevoTipoCategoria" maxlength="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script></script>
@endsection
