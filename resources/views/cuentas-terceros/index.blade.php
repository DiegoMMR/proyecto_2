@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Cuentas Externas
                    <a class="btn btn-success btn-sm float-right" href="{{ route('cuentas-terceros.create') }}">Registrar Cuenta</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col"># Cuenta</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Limite Monto</th>
                        <th scope="col">Limite Transacciones</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($cuentas as $cuenta)
                        <tr>    
                        <td>{{ $cuenta->id }}</td>
                        <td>{{ $cuenta->alias }}</td>
                        <td>{{ $cuenta->cuenta->limite_monto }}</td>
                        <td>{{ $cuenta->cuenta->limite_transacciones }}</td>
                        <td><a class="btn btn-warning btn-sm" href="{{ route('cuentas-terceros.edit', \Hashids::encode($cuenta->id)) }}">Editar</a></td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>

                    {{ $cuentas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection