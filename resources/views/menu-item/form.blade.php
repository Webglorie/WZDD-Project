<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $menuItem->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('url') }}
            {{ Form::text('url', $menuItem->url, ['class' => 'form-control' . ($errors->has('url') ? ' is-invalid' : ''), 'placeholder' => 'Url']) }}
            {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('parent_id', 'Parent ID') }}
            @foreach ($selectMenuItems as $selectMenuItem)
                <div>
                    {{ Form::radio('parent_id', $selectMenuItem->id, $menuItem->parent_id == $selectMenuItem->id, ['id' => 'parent_id_'.$selectMenuItem->id]) }}
                    {{ Form::label('parent_id_'.$selectMenuItem->id, $selectMenuItem->id . ' - ' . $selectMenuItem->name) }}
                    @if ($selectMenuItem->menuItem)
                        <span style="margin-left: 10px; font-style: italic;">(Parent: {{ $selectMenuItem->menuItem->name }})</span>
                    @endif
                </div>
            @endforeach
            {!! $errors->first('parent_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>


    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
