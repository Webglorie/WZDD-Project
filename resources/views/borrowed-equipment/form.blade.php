<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('equipment_id') }}
            {{ Form::select('equipment_id', $allEquipment, $borrowedEquipment->equipment_id, ['class' => 'form-control' . ($errors->has('equipment_id') ? ' is-invalid' : ''), 'placeholder' => 'Select Equipment']) }}
            {!! $errors->first('equipment_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>


        <div class="form-group">
            {{ Form::label('borrowed_date_begin') }}
            {{ Form::text('borrowed_date_begin', $borrowedEquipment->borrowed_date_begin, ['class' => 'form-control' . ($errors->has('borrowed_date_begin') ? ' is-invalid' : ''), 'placeholder' => 'Borrowed Date Begin', 'data-flatpickr' => 'true', 'data-enable-time' => 'true', 'data-date-format' => 'd-m-Y H:i']) }}
            {!! $errors->first('borrowed_date_begin', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('borrowed_date_end') }}
            {{ Form::text('borrowed_date_end', $borrowedEquipment->borrowed_date_end, ['class' => 'form-control' . ($errors->has('borrowed_date_end') ? ' is-invalid' : ''), 'placeholder' => 'Borrowed Date End', 'data-flatpickr' => 'true', 'data-enable-time' => 'true', 'data-date-format' => 'd-m-Y H:i']) }}
            {!! $errors->first('borrowed_date_end', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('borrower') }}
            {{ Form::text('borrower', $borrowedEquipment->borrower, ['class' => 'form-control' . ($errors->has('borrower') ? ' is-invalid' : ''), 'placeholder' => 'Borrower']) }}
            {!! $errors->first('borrower', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ultimo_ticket_number') }}
            {{ Form::text('ultimo_ticket_number', $borrowedEquipment->ultimo_ticket_number, ['class' => 'form-control' . ($errors->has('ultimo_ticket_number') ? ' is-invalid' : ''), 'placeholder' => 'Ultimo Ticket Number']) }}
            {!! $errors->first('ultimo_ticket_number', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
    flatpickr('input[data-flatpickr]', {
        enableTime: true,
        locale: "nl",  // locale for this instance only
        dateFormat: 'd-m-Y H:i',
        // Add any other configuration options as needed
    });
</script>
