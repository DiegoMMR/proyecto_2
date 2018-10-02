<div class="form-group {{ $errors->has('dpi') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('dpi', 'DPI', ['class' => ' control-label']) !!}
        {!! Form::text('dpi', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('dpi', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('nombre', 'Nombre', ['class' => ' control-label']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('email', 'Email', ['class' => ' control-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('direccion') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('direccion', 'Direccion', ['class' => ' control-label']) !!}
        {!! Form::text('direccion', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('direccion', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('telefono') ? 'has-error' : ''}} row">
    <div class="col-10">
        {!! Form::label('telefono', 'Telefono', ['class' => ' control-label']) !!}
        {!! Form::text('telefono', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group row col-lg-6">
    <div class="offset-md-2 col-lg-4">
        <a href="{{ route('clientes.index') }}" class="btn btn-danger btn-md" title="Cancel"><i class="fas fa-ban" aria-hidden="true"></i> Cancelar</a>
    </div>
    <div class="col-lg-4">
        {!! Form::submit(
            isset($submitButtonText) ? $submitButtonText : 'Crear Usuario',
            [
                'class' => 'btn btn-success btn-md'
                ]) !!}
    </div>
</div>