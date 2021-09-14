<?php

namespace App\Http\Requests;

use App\Models\Quran;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQuranRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('quran_create');
    }

    public function rules()
    {
        return [
            'ayah_number' => [
                'string',
                'nullable',
            ],
        ];
    }
}
