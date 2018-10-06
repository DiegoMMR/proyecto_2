@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                Usuarios
                <a class="btn btn-success btn-sm float-right" href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>    
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles[0]->name }}</td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('users.show', \Hashids::encode($user->id)) }}">Mostrar</a>
                            <a class="btn btn-info btn-sm" href="{{ route('users.edit', \Hashids::encode($user->id)) }}">Editar</a>
                        </td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection