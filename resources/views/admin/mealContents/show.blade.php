@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mealContent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meal-contents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mealContent.fields.id') }}
                        </th>
                        <td>
                            {{ $mealContent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mealContent.fields.meal') }}
                        </th>
                        <td>
                            {{ $mealContent->meal->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mealContent.fields.content') }}
                        </th>
                        <td>
                            {!! $mealContent->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mealContent.fields.ayah') }}
                        </th>
                        <td>
                            {{ $mealContent->ayah }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mealContent.fields.surah') }}
                        </th>
                        <td>
                            {{ $mealContent->surah->arabic ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meal-contents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection