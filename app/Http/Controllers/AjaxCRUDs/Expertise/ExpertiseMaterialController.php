<?php


namespace App\Http\Controllers\AjaxCRUDs\Expertise;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\ExpertiseMaterial;
use App\Models\ExpertisePetitionStatus;
use App\Models\ExpertisePetitionType;
use App\Models\Material;
use App\Models\MaterialChildObjectType;
use App\Models\MaterialChildType;
use App\Models\MaterialLanguage;
use App\Models\MaterialObjectType;
use App\Models\MaterialStatus;
use App\Models\MaterialType;
use App\Models\MaterialTypeObjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ExpertiseMaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->exists('expertise'))
                $data = Expertise::find($request->input('expertise'))->materials();
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
                    return $material->language()->value('title');
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
                ->addColumn('action', function (Material $material) {
                    return AppHelper::ajaxIndexActionBlade($material, 'expertise.modal.materials', 'material');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(materials.created_at, '%d-%m-%Y') like ?";
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
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function create(Request $request)
    {
        $typeObjectTypeId = MaterialTypeObjectType::all();
        $typeObjectChildTypeId = MaterialChildObjectType::all();

        $typeRelation = [];
        $childTypeRelation = [];

        foreach ($typeObjectTypeId as $value) {
            $typeRelation[] = [$value->object_type_id, $value->type_id];
        }

        foreach ($typeObjectChildTypeId as $value) {
            $childTypeRelation[] = [$value->type_id, $value->childType_id];
        }

        $statuses = MaterialStatus::pluck('title', 'id')->all();
        $types = MaterialType::pluck('title', 'id')->all();
        $objectTypes = MaterialObjectType::pluck('title', 'id')->all();
        $childTypes = MaterialChildType::pluck('title', 'id')->all();
        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $expertise_id = $request->expertise_id;

        return response()->view('modal-CRUDs.expertise.materials.create', compact(
            'statuses', 'types', 'objectTypes', 'childTypes', 'languages', 'expertise_id', 'typeRelation', 'childTypeRelation'
        ));
    }

    public function store(Request $request)
    {
        $expertise = Expertise::find($request->input('expertise_id'));
        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'name' => 'required',
            'object_type_id' => 'nullable',
            'type_id' => 'nullable',
            'child_type_id' => 'nullable',
            'language_id' => 'nullable',
            'source' => 'nullable',
            'file' => 'nullable',
            'file_id' => 'nullable',
            'file_text' => 'nullable',
            'file_text_comment' => 'nullable',
            'status_id' => 'nullable',
        ]);

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
                    'language_id' => $request->language_id,
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
                $material = Material::create($new_material);
                //create relation between material and expertise
                ExpertiseMaterial::create(
                    [
                        'expertise_id' => $request->expertise_id,
                        'material_id' => $material->id,
                    ]
                );
            }
        } else {

            if ($request->hasFile('file')) {
                $file_id = AppHelper::saveDocument('file', 'materials');
            }

            $material = Material::create($request->except('file') + [
                    'file_id' => $file_id,
                    'creator_id' => auth()->user()->id,
                ]);
            //create relation between material and expertise
            ExpertiseMaterial::create(
                [
                    'expertise_id' => $request->expertise_id,
                    'material_id' => $material->id,
                ]
            );
        }
        return response()->json([
            'entity' => 'material',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, Material $material)
    {
        $typeObjectTypeId = MaterialTypeObjectType::all();
        $typeObjectChildTypeId = MaterialChildObjectType::all();

        $typeRelation = [];
        $childTypeRelation = [];

        foreach ($typeObjectTypeId as $value) {
            $typeRelation[] = [$value->object_type_id, $value->type_id];
        }

        foreach ($typeObjectChildTypeId as $value) {
            $childTypeRelation[] = [$value->type_id, $value->childType_id];
        }
        $statuses = ExpertisePetitionStatus::pluck('title', 'id')->all();
        $types = MaterialType::pluck('title', 'id')->all();
        $objectTypes = MaterialObjectType::pluck('title', 'id')->all();
        $childTypes = MaterialChildType::pluck('title', 'id')->all();
        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.materials.edit', compact(
            'statuses',
            'types',
            'material',
            'objectTypes', 'childTypes',
            'languages', 'expertise_id', 'typeRelation', 'childTypeRelation',
        ));
    }

    public function update(Request $request, Material $material)
    {
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'object_type_id' => 'required|exists:material_object_types,id',
            'type_id' => 'required|exists:material_types,id',
            'child_type_id' => 'required|exists:material_child_types,id',
            'language_id' => 'required|exists:material_languages,id',
            'source' => 'required|string|max:255',
            'status_id' => 'required|exists:material_status,id',
            'expertise_id' => 'required|exists:expertise,id',
            'file_id' => 'nullable',
            'file' => 'nullable',
            'file_text' => 'nullable',
            'file_text_comment' => 'nullable',
        ]);
        if ($request->hasFile('file')) {
            $request->merge([
                'file_id' => AppHelper::saveDocument('file', 'materials'),
            ]);
        }
        $material->update($request->all());
        return response()->json([
            'entity' => 'material',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, Material $material)
    {
        if (!auth()->user()->hasAccessToMaterial($material, 'destroy')) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $material->delete();
        return response()->json('material', 200);
    }

    public function show(Material $material)
    {
        return response()->view('modal-CRUDs.expertise.materials.show', compact('material'));
    }

}
