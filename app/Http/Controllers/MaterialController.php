<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Document;
use App\Models\Expertise;
use App\Models\Material;
use App\Models\MaterialChildObjectType;
use App\Models\MaterialChildType;
use App\Models\MaterialLanguage;
use App\Models\MaterialLanguagesBridge;
use App\Models\MaterialObjectType;
use App\Models\MaterialStatus;
use App\Models\MaterialType;
use App\Models\MaterialTypeObjectType;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaterialController extends Controller
{
    public function __construct()
    {
        set_time_limit(600);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->exists('expertise'))
                $data = Expertise::find($request->input('expertise'))->materials;
            else
                $data = Material::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('object_type', function (Material $material) {
                    return $material->objectType()->value('title');
                })
                ->addColumn('type', function (Material $material) {
                    return $material->type()->value('title');
                })
                ->addColumn('language', function (Material $material) {
                    $languages = $material->language()->value('title');
                    if($languages != null){
                        return $languages;
                    }
                    $result = [];
                    $languages = MaterialLanguagesBridge::where('material_id', $material->id)->get();
                    foreach ($languages as  $key=> $language){
                        $result[$key] = MaterialLanguage::where('id', $language->material_language_id)->value('title');
                    }
                    $languages =  implode(" ", $result);
                    return $languages;
                })
                ->addColumn('status', function (Material $material) {
                    return $material->status()->value('title');
                })
                ->addColumn('creator', function (Material $material) {
                    return $material->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
                })
                ->addColumn('file', function (Material $material) {
                    return AppHelper::showBlade('', $material->file()->first());
                })
                ->addColumn('words', function (Material $material) {
                    return view('materials.index-analyze', compact('material'))->render();
                })
                ->addColumn('action', function (Material $material) {
                    return AppHelper::indexActionBlade($material, 'materials', 'material');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(materials.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('file', function ($query, $keyword) {
                    $sql = "EXISTS(SELECT id FROM documents as t WHERE t.id = materials.file_id AND t.name LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('object_type', function ($query, $keyword) {
                    $sql = "materials.object_type_id IN (SELECT id FROM material_object_types as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('language', function ($query, $keyword) {
                    $sql = "materials.language_id IN (SELECT id FROM material_languages as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('type', function ($query, $keyword) {
                    $sql = "materials.type_id IN (SELECT id FROM material_types as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $sql = "materials.status_id IN (SELECT id FROM material_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['words', 'action'])
                ->toJson();
        }

        // $data = Material::orderBy('id','DESC')->paginate(5);
        return view('materials.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = MaterialType::all();
        $childTypes = MaterialChildType::all();
        $typeObjectTypeId = MaterialTypeObjectType::all();
        $typeObjectChildTypeId = MaterialChildObjectType::all();

        $typeRelation = [];
        $childTypeRelation = [];
        $typeWithTitle = [];

        foreach ($typeObjectTypeId as $value) {
            $typeRelation[] = [$value->object_type_id, $value->type_id];
        }

        foreach ($typeObjectChildTypeId as $value) {
            $childTypeRelation[] = [$value->type_id, $value->childType_id];
        }

        foreach ($types as $value) {
            foreach ($childTypes as $key => $ChildValue) {
                if($value->id == $typeObjectChildTypeId[$key]->type_id){
                    $typeWithTitle[$value->id] = $value->title;
                    $typeWithTitle[$value->title][$ChildValue->id] = $ChildValue->title;
                }
            }
        }

        $objectTypes = MaterialObjectType::pluck('title', 'id')->all();
        $types = MaterialType::pluck('title', 'id')->all();
        $childTypes = MaterialChildType::pluck('title', 'id')->all();
        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $statuses = MaterialStatus::pluck('title', 'id')->all();

        return view('materials.create', compact('objectTypes',
            'types', 'languages', 'statuses', 'typeRelation', 'childTypes', 'childTypeRelation', 'typeWithTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'object_type_id' => 'nullable',
            'child_type_id' => 'nullable',
            'language_id' => 'nullable',
            'source' => 'nullable',
            'file' => 'nullable',
            'file_id' => 'nullable',
            'file_text' => 'nullable',
            'file_text_comment' => 'nullable',
            'status_id' => 'nullable',
        ]);

        $data = $request->all();
        $data['type_id'] = MaterialChildObjectType::where("childType_id", $data["child_type_id"])->get()->pluck('type_id')[0];

        if ($request->has('archive_file_paths')) {

            foreach ($request->archive_file_paths as $key => $file_path) {
                $material_file = AppHelper::pathToUploadedFile(storage_path("app/" . $file_path));
                if (in_array($material_file->extension(), ['mp3', 'mp4'])) {
                    $object_type_id = 2;
                }
                if (in_array($material_file->extension(), ['jpg', 'jpeg', 'png'])) {
                    $object_type_id = 3;
                } else {
                    $object_type_id = 1;
                }
                $new_material = [
                    'name' => $material_file->getClientOriginalName(),
                    'object_type_id' => $object_type_id,
                    'type_id' => MaterialTypeObjectType::where('object_type_id', $object_type_id)->first()->id,
                    'child_type_id' => $data['child_type_id'],
                    'language_id' => $request->language_id[0],
                    'source' => $request->source,
                    'file_id' => AppHelper::saveDocument('file', 'materials', auth()->user()->id, $material_file),
                    'file_text' => $request->archive_file_texts[$key],
                    'file_text_comment' => $request->file_text_comment,
                    'status_id' => 1,
                    'creator_id' => auth()->user()->id,
                ];
                /**
                 * @param Material $material
                 */

                dd('stop');
                Material::create($new_material);
            }
        } else {

            $data['file_id'] = AppHelper::saveDocument('file', 'materials');
            $data['creator_id'] = auth()->id();

            /**
             * @param Material $material
             */

            $languages = $data['language_id']; // Копируем все языки из массива на новую переменную
            $data['language_id'] = null; // Присваиваем null чтобы не вызывало ошибку записи массива в integer

            $material_id = Material::create($data)->id; // Создаем материал и получаем id последнего добавленной записи
            foreach ($languages as $language){
                MaterialLanguagesBridge::create([
                    'material_language_id' => $language,
                    'material_id' => $material_id
                ]);
            }

        }

        return redirect()->route('materials.index')
            ->with('success', __('Material created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        session(['for_modal_material_id' => $id]);
        $material = Material::find($id);

        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $types = MaterialType::all();
        $childTypes = MaterialChildType::all();
        $typeObjectTypeId = MaterialTypeObjectType::all();
        $typeObjectChildTypeId = MaterialChildObjectType::all();

        $typeRelation = [];
        $childTypeRelation = [];
        $typeWithTitle = [];

        foreach ($typeObjectTypeId as $value) {
            $typeRelation[] = [$value->object_type_id, $value->type_id];
        }

        foreach ($typeObjectChildTypeId as $value) {
            $childTypeRelation[] = [$value->type_id, $value->childType_id];
        }

        foreach ($types as $value) {
            foreach ($childTypes as $key => $ChildValue) {
                if($value->id == $typeObjectChildTypeId[$key]->type_id){
                    $typeWithTitle[$value->id] = $value->title;
                    $typeWithTitle[$value->title][$ChildValue->id] = $ChildValue->title;
                }
            }
        }

        session(['for_modal_material_id' => $id]);
        $material = Material::find($id);
        $objectTypes = MaterialObjectType::pluck('title', 'id')->all();
        $types = MaterialType::pluck('title', 'id')->all();
        $childTypes = MaterialChildType::pluck('title', 'id')->all();

        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $statuses = MaterialStatus::pluck('title', 'id')->all();

        // Изменения

        $hasLanguages = [];
        $userLanguages = MaterialLanguagesBridge::where('material_id', $id)->get();

        foreach ($userLanguages as $language){
            array_push($hasLanguages, $language->material_language_id);
        }

        // Конец изменения

        return view('materials.edit', compact('material',
            'objectTypes', 'types', 'childTypes', 'languages', 'hasLanguages', 'statuses', 'typeRelation', 'childTypes', 'childTypeRelation', 'typeWithTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $material = Material::find($id);
        if(!auth()->user()->hasAccessToMaterial($material,'update')){
            return redirect()->back()->with('accessError', __('you do not access!'));
        }
        $this->validate($request, [
            'name' => 'required',
            'object_type_id' => 'nullable',
            'child_type_id' => 'nullable',
            'language_id' => 'nullable',
            'source' => 'nullable',
            'file' => 'nullable',
            'file_id' => 'nullable',
            'file_text' => 'nullable',
            'file_text_comment' => 'nullable',
            'status_id' => 'nullable',
        ]);

        $data = $request->all();
        $data['type_id'] = MaterialChildObjectType::where("childType_id", $data["child_type_id"])->get()->pluck('type_id')[0];


        // Upload file
        if (empty($data['file_id'])) {
            $input['file_id'] = AppHelper::saveDocument('file', 'materials');
        }

        // Изменения

        $languages = $data['language_id'];
        $data['language_id'] = null;

        MaterialLanguagesBridge::where('material_id', $id)->delete();

        $material->update($data);
        foreach ($languages as $language){
            MaterialLanguagesBridge::create([
                'material_language_id' => $language,
                'material_id' => $id
            ]);
        }

        // Конец изменения

        return redirect()->route('materials.index')
            ->with('success', __('Material updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $material = Material::find($id);
        if(!auth()->user()->hasAccessToMaterial($material,'destroy')){
            return redirect()->back()->with('accessError', __('you do not access!'));
        }

        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', __('Material deleted successfully'));
    }
}
