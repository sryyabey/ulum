@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.mealContent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.meal-contents.update", [$mealContent->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="meal_id">{{ trans('cruds.mealContent.fields.meal') }}</label>
                <select class="form-control select2 {{ $errors->has('meal') ? 'is-invalid' : '' }}" name="meal_id" id="meal_id">
                    @foreach($meals as $id => $entry)
                        <option value="{{ $id }}" {{ (old('meal_id') ? old('meal_id') : $mealContent->meal->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('meal'))
                    <span class="text-danger">{{ $errors->first('meal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mealContent.fields.meal_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="content">{{ trans('cruds.mealContent.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content', $mealContent->content) !!}</textarea>
                @if($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mealContent.fields.content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ayah">{{ trans('cruds.mealContent.fields.ayah') }}</label>
                <input class="form-control {{ $errors->has('ayah') ? 'is-invalid' : '' }}" type="text" name="ayah" id="ayah" value="{{ old('ayah', $mealContent->ayah) }}">
                @if($errors->has('ayah'))
                    <span class="text-danger">{{ $errors->first('ayah') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mealContent.fields.ayah_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="surah_id">{{ trans('cruds.mealContent.fields.surah') }}</label>
                <select class="form-control select2 {{ $errors->has('surah') ? 'is-invalid' : '' }}" name="surah_id" id="surah_id">
                    @foreach($surahs as $id => $entry)
                        <option value="{{ $id }}" {{ (old('surah_id') ? old('surah_id') : $mealContent->surah->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('surah'))
                    <span class="text-danger">{{ $errors->first('surah') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mealContent.fields.surah_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.meal-contents.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $mealContent->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection