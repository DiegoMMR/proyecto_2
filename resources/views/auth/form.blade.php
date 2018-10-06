    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}} row">
        <div class="col-10">
            {!! Form::label('name', 'Nombre', ['class' => ' control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}} row">
        <div class="col-10">
            {!! Form::label('email', 'Email', ['class' => ' control-label']) !!}
            {!! Form::email('email', null, ['class' => 'form-control','required']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('role') ? 'has-error' : ''}} row">

        <div class="col-6">
            {!! Form::label('role', 'Usuario', ['class' => ' control-label']) !!}
            {!! Form::select('role', $roles, null, [ 'class' => 'form-control selectpicker', 'id'=>'id', 'required'=>'required']) !!}
            {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-4">
        {!! Form::submit(
            isset($submitButtonText) ? $submitButtonText : 'Crear Usuario',
            [
                'class' => 'btn btn-success btn-md'
                ]) !!}
    </div>