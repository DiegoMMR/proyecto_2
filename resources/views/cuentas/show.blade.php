@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$cuenta->nombre}}</div>

                <div class="card-body">

                    <b># Cuenta</b> {{$cuenta->id}} <br>
                    <b>Nombre</b> {{$cuenta->nombre}} <br>
                    <b>Cliente</b> <a href="{{ route('clientes.show', \Hashids::encode($cuenta->cliente->id)) }}">{{$cuenta->cliente->nombre}}</a>  <br>
                    <b>Fecha de registro</b> {{ \Carbon\Carbon::parse($cuenta->created_at)->format('d/m/Y')}} <br>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection