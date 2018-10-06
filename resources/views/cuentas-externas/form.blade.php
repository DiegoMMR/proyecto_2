<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('nombre', 'Nombre', ['class' => ' control-label']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('saldo') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('saldo', 'Saldo Inicial', ['class' => ' control-label']) !!}
        {!! Form::text('saldo', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('saldo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('limite_monto') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('limite_monto', 'Monto Limite', ['class' => ' control-label']) !!}
        {!! Form::text('limite_monto', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('limite_monto', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('limite_transacciones') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('limite_transacciones', 'Limite Transacciones por Mes', ['class' => ' control-label']) !!}
        {!! Form::number('limite_transacciones', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('limite_transacciones', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row col-lg-6">
    <div class="offset-md-2 col-lg-4">
        <a href="{{ route('cuentas.index') }}" class="btn btn-danger btn-md" title="Cancel"><i class="fas fa-ban" aria-hidden="true"></i> Cancelar</a>
    </div>
    <div class="col-lg-4">
        {!! Form::submit(
            isset($submitButtonText) ? $submitButtonText : 'Crear Cuenta',
            [
                'class' => 'btn btn-success btn-md'
                ]) !!}
    </div>
</div>