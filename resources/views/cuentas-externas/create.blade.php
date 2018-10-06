@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Cuenta Externa</div>

                <div class="card-body">
                    {!! Form::open([
                            'route' => 'cuentas-externas.store',
                            'class' => '',
                            'files' => true]) !!}

                    @include ('cuentas-externas.form')


                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection