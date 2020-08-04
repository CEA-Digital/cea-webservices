@extends('layouts.main')

@section('content')

    <div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-11 main-section">
            <h1 class="text-center text-danger">File Input Example</h1><br>

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
