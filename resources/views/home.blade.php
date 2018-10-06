@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="jumbotron">
                <h1 class="display-4">Bienvenido {{Auth::user()->name}}!</h1>
                <hr class="my-4">
            </div>
        </div>
    </div>
</div>
@endsection
