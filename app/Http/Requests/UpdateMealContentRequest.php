<?php

namespace App\Http\Requests;

use App\Models\MealContent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMealContentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meal_content_edit');
    }

    public function rules()
    {
        return [
            'ayah' => [
                'string',
                'nullable',
            ],
        ];
    }
}
