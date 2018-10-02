@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Cliente {{$cliente->nombre}}</div>

                <div class="card-body">
                    {!! Form::model($cliente, [
                            'method' => 'PATCH',
                            'route' => ['clientes.update', \Hashids::encode($cliente->id)],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                    @include ('clientes.form', ['submitButtonText' => 'Actualizar'])



                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection