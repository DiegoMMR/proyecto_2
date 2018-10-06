@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Movimiento</div>

                <div class="card-body">
                    {!! Form::open([
                            'route' => 'hacer-movimiento',
                            'class' => '',
                            'files' => true]) !!}

                        <div class="form-group {{ $errors->has('cuenta_id') ? 'has-error' : ''}} row">

                            <div class="col-6">
                                {!! Form::label('cuenta_id', 'No. Cuenta', ['class' => ' control-label']) !!}
                                {!! Form::select('cuenta_id', $cuentas, null, [ 'class' => 'form-control selectpicker', 'id'=>'id', 'required'=>'required']) !!}
                                {!! $errors->first('cuenta_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}} row">

                            <div class="col-6">
                                {!! Form::label('tipo', 'Tipo', ['class' => ' control-label']) !!}
                                {!! Form::select('tipo', $tipos, null, [ 'class' => 'form-control selectpicker', 'id'=>'id', 'required'=>'required']) !!}
                                {!! $errors->first('tipo', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('monto') ? 'has-error' : ''}} row">
                            <div class="col-10">
                                {!! Form::label('monto', 'Monto', ['class' => ' control-label']) !!}
                                {!! Form::text('monto', null, ['class' => 'form-control','required']) !!}
                                {!! $errors->first('monto', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            {!! Form::submit('Crear',['class' => 'btn btn-success btn-md']) !!}
                        </div>


                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>




@endsection