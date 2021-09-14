<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMealContentRequest;
use App\Http\Requests\UpdateMealContentRequest;
use App\Http\Resources\Admin\MealContentResource;
use App\Models\MealContent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealContentsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('meal_content_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MealContentResource(MealContent::with(['meal', 'surah'])->get());
    }

    public function store(StoreMealContentRequest $request)
    {
        $mealContent = MealContent::create($request->all());

        return (new MealContentResource($mealContent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MealContent $mealContent)
    {
        abort_if(Gate::denies('meal_content_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MealContentResource($mealContent->load(['meal', 'surah']));
    }

    public function update(UpdateMealContentRequest $request, MealContent $mealContent)
    {
        $mealContent->update($request->all());

        return (new MealContentResource($mealContent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MealContent $mealContent)
    {
        abort_if(Gate::denies('meal_content_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mealContent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
