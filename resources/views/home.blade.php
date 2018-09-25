@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::user()->esAdministrador())
                        <b>Rol: Administrador</b> <br>
                    @endif
                    @if (Auth::user()->esEmpleado())
                        <b>Rol: Empleado</b> <br>
                    @endif
                    @if (Auth::user()->esCliente())
                        <b>Rol: Cliente</b> <br>
                    @endif
                    Solo si estas logueado puedes ver esta pagina
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
