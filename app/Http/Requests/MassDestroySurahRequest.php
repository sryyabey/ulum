<?php

namespace App\Http\Requests;

use App\Models\Surah;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySurahRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('surah_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:surahs,id',
        ];
    }
}
