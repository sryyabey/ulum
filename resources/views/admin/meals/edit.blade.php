@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.meal.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.meals.update", [$meal->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.meal.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $meal->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.meal.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="writer">{{ trans('cruds.meal.fields.writer') }}</label>
                <input class="form-control {{ $errors->has('writer') ? 'is-invalid' : '' }}" type="text" name="writer" id="writer" value="{{ old('writer', $meal->writer) }}">
                @if($errors->has('writer'))
                    <span class="text-danger">{{ $errors->first('writer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.meal.fields.writer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.meal.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $meal->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.meal.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection