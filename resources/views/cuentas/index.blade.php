@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Cuentas 
                    <a class="btn btn-success btn-sm float-right" href="{{ route('cuentas.create') }}">Crear Cuenta</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col"># Cuenta</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">nombre</th>
                        <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($cuentas as $cuenta)
                        <tr>    
                        <td>{{ $cuenta->id }}</td>
                        <td>{{ $cuenta->cliente->nombre }}</td>
                        <td>{{ $cuenta->nombre }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('cuentas.show', \Hashids::encode($cuenta->id)) }}">Mostrar</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('cuentas.edit', \Hashids::encode($cuenta->id)) }}">Editar</a>
                        </td>
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