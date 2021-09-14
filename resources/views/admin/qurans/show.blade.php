@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.quran.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.qurans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.quran.fields.id') }}
                        </th>
                        <td>
                            {{ $quran->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quran.fields.ayah_number') }}
                        </th>
                        <td>
                            {{ $quran->ayah_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quran.fields.ayah') }}
                        </th>
                        <td>
                            {!! $quran->ayah !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.quran.fields.surah') }}
                        </th>
                        <td>
                            {{ $quran->surah->arabic ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.qurans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection