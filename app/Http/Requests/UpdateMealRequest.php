<?php

namespace App\Http\Requests;

use App\Models\Meal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMealRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meal_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'writer' => [
                'string',
                'nullable',
            ],
        ];
    }
}
