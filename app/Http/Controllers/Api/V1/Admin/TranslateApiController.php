<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTranslateRequest;
use App\Http\Requests\UpdateTranslateRequest;
use App\Http\Resources\Admin\TranslateResource;
use App\Models\Translate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslateApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('translate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TranslateResource(Translate::with(['lang', 'surah'])->get());
    }

    public function store(StoreTranslateRequest $request)
    {
        $translate = Translate::create($request->all());

        return (new TranslateResource($translate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Translate $translate)
    {
        abort_if(Gate::denies('translate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TranslateResource($translate->load(['lang', 'surah']));
    }

    public function update(UpdateTranslateRequest $request, Translate $translate)
    {
        $translate->update($request->all());

        return (new TranslateResource($translate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Translate $translate)
    {
        abort_if(Gate::denies('translate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $translate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
