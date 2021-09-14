@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.translate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.translates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="lang_id">{{ trans('cruds.translate.fields.lang') }}</label>
                <select class="form-control select2 {{ $errors->has('lang') ? 'is-invalid' : '' }}" name="lang_id" id="lang_id">
                    @foreach($langs as $id => $entry)
                        <option value="{{ $id }}" {{ old('lang_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('lang'))
                    <span class="text-danger">{{ $errors->first('lang') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.translate.fields.lang_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ayah">{{ trans('cruds.translate.fields.ayah') }}</label>
                <input class="form-control {{ $errors->has('ayah') ? 'is-invalid' : '' }}" type="number" name="ayah" id="ayah" value="{{ old('ayah', '') }}" step="1">
                @if($errors->has('ayah'))
                    <span class="text-danger">{{ $errors->first('ayah') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.translate.fields.ayah_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="translate">{{ trans('cruds.translate.fields.translate') }}</label>
                <textarea class="form-control {{ $errors->has('translate') ? 'is-invalid' : '' }}" name="translate" id="translate">{{ old('translate') }}</textarea>
                @if($errors->has('translate'))
                    <span class="text-danger">{{ $errors->first('translate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.translate.fields.translate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="surah_id">{{ trans('cruds.translate.fields.surah') }}</label>
                <select class="form-control select2 {{ $errors->has('surah') ? 'is-invalid' : '' }}" name="surah_id" id="surah_id">
                    @foreach($surahs as $id => $entry)
                        <option value="{{ $id }}" {{ old('surah_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('surah'))
                    <span class="text-danger">{{ $errors->first('surah') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.translate.fields.surah_helper') }}</span>
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