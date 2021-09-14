<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreQuranRequest;
use App\Http\Requests\UpdateQuranRequest;
use App\Http\Resources\Admin\QuranResource;
use App\Models\Quran;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuranApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('quran_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuranResource(Quran::with(['surah'])->get());
    }

    public function store(StoreQuranRequest $request)
    {
        $quran = Quran::create($request->all());

        return (new QuranResource($quran))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Quran $quran)
    {
        abort_if(Gate::denies('quran_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuranResource($quran->load(['surah']));
    }

    public function update(UpdateQuranRequest $request, Quran $quran)
    {
        $quran->update($request->all());

        return (new QuranResource($quran))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Quran $quran)
    {
        abort_if(Gate::denies('quran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quran->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
