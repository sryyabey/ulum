<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSurahRequest;
use App\Http\Requests\UpdateSurahRequest;
use App\Http\Resources\Admin\SurahResource;
use App\Models\Surah;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurahApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('surah_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SurahResource(Surah::all());
    }

    public function store(StoreSurahRequest $request)
    {
        $surah = Surah::create($request->all());

        return (new SurahResource($surah))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Surah $surah)
    {
        abort_if(Gate::denies('surah_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SurahResource($surah);
    }

    public function update(UpdateSurahRequest $request, Surah $surah)
    {
        $surah->update($request->all());

        return (new SurahResource($surah))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Surah $surah)
    {
        abort_if(Gate::denies('surah_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surah->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
