<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuranRequest;
use App\Http\Requests\StoreQuranRequest;
use App\Http\Requests\UpdateQuranRequest;
use App\Models\Quran;
use App\Models\Surah;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class QuranController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('quran_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Quran::with(['surah'])->select(sprintf('%s.*', (new Quran())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'quran_show';
                $editGate = 'quran_edit';
                $deleteGate = 'quran_delete';
                $crudRoutePart = 'qurans';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('ayah_number', function ($row) {
                return $row->ayah_number ? $row->ayah_number : '';
            });
            $table->addColumn('surah_arabic', function ($row) {
                return $row->surah ? $row->surah->arabic : '';
            });

            $table->editColumn('surah.latin', function ($row) {
                return $row->surah ? (is_string($row->surah) ? $row->surah : $row->surah->latin) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'surah']);

            return $table->make(true);
        }

        $surahs = Surah::get();

        return view('admin.qurans.index', compact('surahs'));
    }

    public function create()
    {
        abort_if(Gate::denies('quran_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.qurans.create', compact('surahs'));
    }

    public function store(StoreQuranRequest $request)
    {
        $quran = Quran::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $quran->id]);
        }

        return redirect()->route('admin.qurans.index');
    }

    public function edit(Quran $quran)
    {
        abort_if(Gate::denies('quran_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quran->load('surah');

        return view('admin.qurans.edit', compact('surahs', 'quran'));
    }

    public function update(UpdateQuranRequest $request, Quran $quran)
    {
        $quran->update($request->all());

        return redirect()->route('admin.qurans.index');
    }

    public function show(Quran $quran)
    {
        abort_if(Gate::denies('quran_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quran->load('surah');

        return view('admin.qurans.show', compact('quran'));
    }

    public function destroy(Quran $quran)
    {
        abort_if(Gate::denies('quran_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quran->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuranRequest $request)
    {
        Quran::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('quran_create') && Gate::denies('quran_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Quran();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
