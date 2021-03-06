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
                    @if (!Auth::user()->esCliente())                        
                        <b>Cliente</b> <a href="{{ route('clientes.show', \Hashids::encode($cuenta->cliente->id)) }}">{{$cuenta->cliente->nombre}}</a>  <br>
                    @endif
                    <b>Fecha de registro</b> {{ \Carbon\Carbon::parse($cuenta->created_at)->format('d/m/Y')}} 
                    <hr>

                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col"># Cuenta</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Saldo Anterior</th>
                        <th scope="col">Saldo Nuevo</th>
                        <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($movimientos as $movimiento)
                        <tr>    
                            <td>{{ $movimiento->cuenta_id }}</td>
                            <td>{{ $movimiento->tipo }}</td>
                            <td>Q. {{ $movimiento->monto }}</td>
                            <td>Q. {{ $movimiento->saldo_anterior }}</td>
                            <td>Q. {{ $movimiento->saldo_nuevo }}</td>
                            <td>{{ date('d/m/Y H:i a', strtotime($movimiento->created_at)) }}</td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>

                    {{ $movimientos->links() }}

                </div>
            </div>
        </div>
    </div>
</div>


@endsection