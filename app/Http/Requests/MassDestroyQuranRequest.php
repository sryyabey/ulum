<?php

namespace App\Http\Requests;

use App\Models\Quran;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuranRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:qurans,id',
        ];
    }
}
