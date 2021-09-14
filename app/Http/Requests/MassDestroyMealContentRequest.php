<?php

namespace App\Http\Requests;

use App\Models\MealContent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMealContentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('meal_content_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:meal_contents,id',
        ];
    }
}
