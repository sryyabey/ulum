<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\Admin\MealResource;
use App\Models\Meal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('meal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MealResource(Meal::all());
    }

    public function store(StoreMealRequest $request)
    {
        $meal = Meal::create($request->all());

        return (new MealResource($meal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Meal $meal)
    {
        abort_if(Gate::denies('meal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MealResource($meal);
    }

    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $meal->update($request->all());

        return (new MealResource($meal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Meal $meal)
    {
        abort_if(Gate::denies('meal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
