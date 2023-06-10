<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Tijd') }}
            {{ Form::text('time', $agendaItem->time, ['class' => 'form-control' . ($errors->has('time') ? ' is-invalid' : ''), 'placeholder' => 'Geplande tijd', 'data-flatpickr' => true]) }}
            {!! $errors->first('time', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Locatie') }}
            {{ Form::select('location', ['Eindhoven' => 'Eindhoven', 'Veldhoven' => 'Veldhoven'], $agendaItem->location, ['class' => 'form-control' . ($errors->has('location') ? ' is-invalid' : ''), 'placeholder' => 'Selecteer een locatie']) }}
            {!! $errors->first('location', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Beschrijving') }}
            {{ Form::textarea('description', $agendaItem->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Beschrijving', 'id' => 'description']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Toevoegen') }}</button>
    </div>
</div>
