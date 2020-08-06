@extends('layouts.main')

@section('content')

    <div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-11 main-section">
            <h1 class="mt-4">Galeria de imágenes
                <div class="btn-group" role="group">
                    <a class="btn btn-sm btn-success"
                       id="botonAbrirModalNuevaCategoria"
                       href="{{route("imagenes",$idServicio)}}">
                        <span class="fas fa-plus"></span> Listo
                    </a>
                </div>
            </h1>
            {!! csrf_field() !!}
            <div class="form-group">
                <div class="file-loading">
                    <input id="imagenesgaleria" type="file" name="file" multiple class="file"   data-overwrite-initial="false"    data-min-file-count="1">
                </div>
                 <input id="idServicio" name="idServicio" value="{{$idServicio}}" type="hidden" >

            </div>

        </div>
    </div>
</div>


@endsection
