<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySurahRequest;
use App\Http\Requests\StoreSurahRequest;
use App\Http\Requests\UpdateSurahRequest;
use App\Models\Surah;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SurahController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('surah_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Surah::query()->select(sprintf('%s.*', (new Surah())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'surah_show';
                $editGate = 'surah_edit';
                $deleteGate = 'surah_delete';
                $crudRoutePart = 'surahs';

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
            $table->editColumn('arabic', function ($row) {
                return $row->arabic ? $row->arabic : '';
            });
            $table->editColumn('latin', function ($row) {
                return $row->latin ? $row->latin : '';
            });
            $table->editColumn('sajda', function ($row) {
                return $row->sajda ? $row->sajda : '';
            });
            $table->editColumn('ayah', function ($row) {
                return $row->ayah ? $row->ayah : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.surahs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('surah_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surahs.create');
    }

    public function store(StoreSurahRequest $request)
    {
        $surah = Surah::create($request->all());

        return redirect()->route('admin.surahs.index');
    }

    public function edit(Surah $surah)
    {
        abort_if(Gate::denies('surah_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surahs.edit', compact('surah'));
    }

    public function update(UpdateSurahRequest $request, Surah $surah)
    {
        $surah->update($request->all());

        return redirect()->route('admin.surahs.index');
    }

    public function show(Surah $surah)
    {
        abort_if(Gate::denies('surah_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.surahs.show', compact('surah'));
    }

    public function destroy(Surah $surah)
    {
        abort_if(Gate::denies('surah_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $surah->delete();

        return back();
    }

    public function massDestroy(MassDestroySurahRequest $request)
    {
        Surah::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
