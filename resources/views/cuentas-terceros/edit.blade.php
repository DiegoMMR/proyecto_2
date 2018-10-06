@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cuenta {{$cuenta->alias}}</div>

                <div class="card-body">
                    {!! Form::model($cuenta, [
                            'method' => 'PATCH',
                            'route' => ['cuentas-terceros.update', \Hashids::encode($cuenta->id)],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                    @include ('cuentas-terceros.form', ['submitButtonText' => 'Actualizar'])



                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection