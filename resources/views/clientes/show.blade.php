@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$cliente->nombre}}</div>

                <div class="card-body">

                    <b>DPI</b> {{$cliente->dpi}} <br>
                    <b>Nombre</b> {{$cliente->nombre}} <br>
                    <b>Email</b> {{$cliente->email}} <br>
                    <b>Telefono</b> {{$cliente->telefono}} <br>
                    <b>Fecha de registro</b> {{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y')}} <br>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection