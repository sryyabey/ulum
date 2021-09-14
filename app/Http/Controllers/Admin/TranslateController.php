<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTranslateRequest;
use App\Http\Requests\StoreTranslateRequest;
use App\Http\Requests\UpdateTranslateRequest;
use App\Models\Language;
use App\Models\Surah;
use App\Models\Translate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TranslateController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('translate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Translate::with(['lang', 'surah'])->select(sprintf('%s.*', (new Translate())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'translate_show';
                $editGate = 'translate_edit';
                $deleteGate = 'translate_delete';
                $crudRoutePart = 'translates';

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
            $table->addColumn('lang_name', function ($row) {
                return $row->lang ? $row->lang->name : '';
            });

            $table->editColumn('lang.sort_name', function ($row) {
                return $row->lang ? (is_string($row->lang) ? $row->lang : $row->lang->sort_name) : '';
            });
            $table->editColumn('ayah', function ($row) {
                return $row->ayah ? $row->ayah : '';
            });
            $table->editColumn('translate', function ($row) {
                return $row->translate ? $row->translate : '';
            });
            $table->addColumn('surah_arabic', function ($row) {
                return $row->surah ? $row->surah->arabic : '';
            });

            $table->editColumn('surah.latin', function ($row) {
                return $row->surah ? (is_string($row->surah) ? $row->surah : $row->surah->latin) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'lang', 'surah']);

            return $table->make(true);
        }

        $languages = Language::get();
        $surahs    = Surah::get();

        return view('admin.translates.index', compact('languages', 'surahs'));
    }

    public function create()
    {
        abort_if(Gate::denies('translate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $langs = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.translates.create', compact('langs', 'surahs'));
    }

    public function store(StoreTranslateRequest $request)
    {
        $translate = Translate::create($request->all());

        return redirect()->route('admin.translates.index');
    }

    public function edit(Translate $translate)
    {
        abort_if(Gate::denies('translate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $langs = Language::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        $translate->load('lang', 'surah');

        return view('admin.translates.edit', compact('langs', 'surahs', 'translate'));
    }

    public function update(UpdateTranslateRequest $request, Translate $translate)
    {
        $translate->update($request->all());

        return redirect()->route('admin.translates.index');
    }

    public function show(Translate $translate)
    {
        abort_if(Gate::denies('translate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $translate->load('lang', 'surah');

        return view('admin.translates.show', compact('translate'));
    }

    public function destroy(Translate $translate)
    {
        abort_if(Gate::denies('translate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $translate->delete();

        return back();
    }

    public function massDestroy(MassDestroyTranslateRequest $request)
    {
        Translate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
