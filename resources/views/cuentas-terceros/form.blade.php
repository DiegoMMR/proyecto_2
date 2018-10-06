
    
@if (!isset($cuenta))
<div class="form-group {{ $errors->has('cuenta_externa_id') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('cuenta_externa_id', '# Cuenta', ['class' => ' control-label']) !!}
        {!! Form::text('cuenta_externa_id', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('cuenta_externa_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('alias') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('alias', 'Alias', ['class' => ' control-label']) !!}
        {!! Form::text('alias', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('alias', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row col-lg-6">
    <div class="offset-md-2 col-lg-4">
        <a href="{{ route('cuentas.index') }}" class="btn btn-danger btn-md" title="Cancel"><i class="fas fa-ban" aria-hidden="true"></i> Cancelar</a>
    </div>
    <div class="col-lg-4">
        {!! Form::submit(
            isset($submitButtonText) ? $submitButtonText : 'Registrar Cuenta',
            [
                'class' => 'btn btn-success btn-md'
                ]) !!}
    </div>
</div>