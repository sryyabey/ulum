<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMealContentRequest;
use App\Http\Requests\StoreMealContentRequest;
use App\Http\Requests\UpdateMealContentRequest;
use App\Models\Meal;
use App\Models\MealContent;
use App\Models\Surah;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MealContentsController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('meal_content_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MealContent::with(['meal', 'surah'])->select(sprintf('%s.*', (new MealContent())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'meal_content_show';
                $editGate = 'meal_content_edit';
                $deleteGate = 'meal_content_delete';
                $crudRoutePart = 'meal-contents';

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
            $table->addColumn('meal_name', function ($row) {
                return $row->meal ? $row->meal->name : '';
            });

            $table->editColumn('meal.writer', function ($row) {
                return $row->meal ? (is_string($row->meal) ? $row->meal : $row->meal->writer) : '';
            });
            $table->editColumn('ayah', function ($row) {
                return $row->ayah ? $row->ayah : '';
            });
            $table->addColumn('surah_arabic', function ($row) {
                return $row->surah ? $row->surah->arabic : '';
            });

            $table->editColumn('surah.latin', function ($row) {
                return $row->surah ? (is_string($row->surah) ? $row->surah : $row->surah->latin) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'meal', 'surah']);

            return $table->make(true);
        }

        $meals  = Meal::get();
        $surahs = Surah::get();

        return view('admin.mealContents.index', compact('meals', 'surahs'));
    }

    public function create()
    {
        abort_if(Gate::denies('meal_content_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meals = Meal::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mealContents.create', compact('meals', 'surahs'));
    }

    public function store(StoreMealContentRequest $request)
    {
        $mealContent = MealContent::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $mealContent->id]);
        }

        return redirect()->route('admin.meal-contents.index');
    }

    public function edit(MealContent $mealContent)
    {
        abort_if(Gate::denies('meal_content_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meals = Meal::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $surahs = Surah::pluck('arabic', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mealContent->load('meal', 'surah');

        return view('admin.mealContents.edit', compact('meals', 'surahs', 'mealContent'));
    }

    public function update(UpdateMealContentRequest $request, MealContent $mealContent)
    {
        $mealContent->update($request->all());

        return redirect()->route('admin.meal-contents.index');
    }

    public function show(MealContent $mealContent)
    {
        abort_if(Gate::denies('meal_content_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mealContent->load('meal', 'surah');

        return view('admin.mealContents.show', compact('mealContent'));
    }

    public function destroy(MealContent $mealContent)
    {
        abort_if(Gate::denies('meal_content_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mealContent->delete();

        return back();
    }

    public function massDestroy(MassDestroyMealContentRequest $request)
    {
        MealContent::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('meal_content_create') && Gate::denies('meal_content_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new MealContent();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
