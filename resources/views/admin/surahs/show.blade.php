@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.surah.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.surahs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.surah.fields.id') }}
                        </th>
                        <td>
                            {{ $surah->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surah.fields.arabic') }}
                        </th>
                        <td>
                            {{ $surah->arabic }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surah.fields.latin') }}
                        </th>
                        <td>
                            {{ $surah->latin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surah.fields.sajda') }}
                        </th>
                        <td>
                            {{ $surah->sajda }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.surah.fields.ayah') }}
                        </th>
                        <td>
                            {{ $surah->ayah }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.surahs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection