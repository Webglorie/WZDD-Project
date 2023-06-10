<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Naam') }}
            {{ Form::text('name', $attendanceCategory->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Naam van de categorie']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="modal-footer">

    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Opslaan') }}</button>
    </div>
    </div>
</div>
