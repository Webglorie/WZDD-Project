<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('time') }}
            {{ Form::text('time', $agendaItem->time, ['class' => 'form-control' . ($errors->has('time') ? ' is-invalid' : ''), 'placeholder' => 'Time', 'data-flatpickr' => true]) }}
            {!! $errors->first('time', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('location') }}
            {{ Form::select('location', ['Eindhoven' => 'Eindhoven', 'Veldhoven' => 'Veldhoven'], $agendaItem->location, ['class' => 'form-control' . ($errors->has('location') ? ' is-invalid' : ''), 'placeholder' => 'Select Location']) }}
            {!! $errors->first('location', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('description') }}
            {{ Form::textarea('description', $agendaItem->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description', 'id' => 'description']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
