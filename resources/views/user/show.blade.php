@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{$user->name}}</div>

                <div class="card-body">

                    <b>id</b> {{$user->id}} <br>
                    <b>Nombre</b> {{$user->name}} <br>
                    <b>Correo</b> {{$user->email}} <br>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection