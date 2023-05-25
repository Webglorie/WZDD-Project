<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('problem_number') }}
            {{ Form::text('problem_number', $problem->problem_number, ['class' => 'form-control' . ($errors->has('problem_number') ? ' is-invalid' : ''), 'placeholder' => 'Problem Number']) }}
            {!! $errors->first('problem_number', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('description') }}
            {{ Form::textarea('description', $problem->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description', 'id' => 'description']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
