@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista de Etiquetas
                        <a href="{{ route('tags.create') }}" class="btn btn-sm btn-primary pull-right">
                            Crear Etiqueta
                        </a>
                    </div>


                    <div class="panel-body">
                        {!! Form::open(['route' => 'tags.store']) !!}
                            @include('admin.tags.partials.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection