@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.translate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.translates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.translate.fields.id') }}
                        </th>
                        <td>
                            {{ $translate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translate.fields.lang') }}
                        </th>
                        <td>
                            {{ $translate->lang->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translate.fields.ayah') }}
                        </th>
                        <td>
                            {{ $translate->ayah }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translate.fields.translate') }}
                        </th>
                        <td>
                            {{ $translate->translate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.translate.fields.surah') }}
                        </th>
                        <td>
                            {{ $translate->surah->arabic ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.translates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection