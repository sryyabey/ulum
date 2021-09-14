<?php

namespace App\Http\Requests;

use App\Models\Translate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTranslateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('translate_edit');
    }

    public function rules()
    {
        return [
            'ayah' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
