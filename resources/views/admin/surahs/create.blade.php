@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.surah.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.surahs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="arabic">{{ trans('cruds.surah.fields.arabic') }}</label>
                <input class="form-control {{ $errors->has('arabic') ? 'is-invalid' : '' }}" type="text" name="arabic" id="arabic" value="{{ old('arabic', '') }}">
                @if($errors->has('arabic'))
                    <span class="text-danger">{{ $errors->first('arabic') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.surah.fields.arabic_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="latin">{{ trans('cruds.surah.fields.latin') }}</label>
                <input class="form-control {{ $errors->has('latin') ? 'is-invalid' : '' }}" type="text" name="latin" id="latin" value="{{ old('latin', '') }}">
                @if($errors->has('latin'))
                    <span class="text-danger">{{ $errors->first('latin') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.surah.fields.latin_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sajda">{{ trans('cruds.surah.fields.sajda') }}</label>
                <input class="form-control {{ $errors->has('sajda') ? 'is-invalid' : '' }}" type="text" name="sajda" id="sajda" value="{{ old('sajda', '') }}">
                @if($errors->has('sajda'))
                    <span class="text-danger">{{ $errors->first('sajda') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.surah.fields.sajda_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ayah">{{ trans('cruds.surah.fields.ayah') }}</label>
                <input class="form-control {{ $errors->has('ayah') ? 'is-invalid' : '' }}" type="number" name="ayah" id="ayah" value="{{ old('ayah', '') }}" step="1">
                @if($errors->has('ayah'))
                    <span class="text-danger">{{ $errors->first('ayah') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.surah.fields.ayah_helper') }}</span>
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