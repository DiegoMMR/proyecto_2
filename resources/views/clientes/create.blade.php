@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Cliente</div>

                <div class="card-body">
                    {!! Form::open([
                            'route' => 'clientes.store',
                            'class' => '',
                            'files' => true]) !!}

                    @include ('clientes.form')


                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection