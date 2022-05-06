<?php


namespace App\Http\Controllers\AjaxCRUDs\Materials;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\Material;
use App\Models\MaterialConclusion;
use App\Models\MaterialConclusionOption;
use App\Models\MaterialConclusionStatus;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaterialExpertConclusionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->exists('expertise'))
            $data = Expertise::find($request->input('expertise'))->conclusions()->select("material_conclusions.*");
        elseif ($request->exists('material'))
            $data = Material::find($request->input('material'))->conclusions()->select("material_conclusions.*");
        else
            $data = MaterialConclusion::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->addColumn('status', function (MaterialConclusion $conclusion) {
                return $conclusion->status()->value('title');
            })
            ->addColumn('materials', function (MaterialConclusion $conclusion) {
                return AppHelper::showBlade('', $conclusion->materials()->pluck('name')->all());
            })
            ->addColumn('options', function (MaterialConclusion $conclusion) {
                return AppHelper::showBlade('', $conclusion->options()->pluck('title')->all());
            })
            ->addColumn('experts', function (MaterialConclusion $conclusion) {
                return $conclusion->experts()->value(DB::raw("GROUP_CONCAT(CONCAT_WS(' ', last_name, name, middle_name) SEPARATOR ', ')"));
            })
            ->addColumn('file', function (MaterialConclusion $conclusion) {
                return AppHelper::showBlade('', $conclusion->file()->first());
            })
            ->addColumn('action', function (MaterialConclusion $conclusion) {
                return AppHelper::AjaxIndexActionBlade($conclusion, 'material.modal.conclusions', 'material-conclusion');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(material_conclusions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('options', function ($query, $keyword) {
                $sql = "material_conclusions.id IN (
                            SELECT conclusion_id FROM material_conclusion_options as t
                            INNER JOIN material_conclusion_option as t2 ON t2.option_id = t.id WHERE t.title LIKE ?
                        )";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $sql = "material_conclusions.status_id IN (SELECT id FROM material_conclusion_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $statuses = MaterialConclusionStatus::pluck('title', 'id')->all();
        $options = MaterialConclusionOption::query()->pluck('title', 'id')->all();
//        $experts = User::pluck('name', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $materials = Material::query()->where('id', '=', $request->material_id)->pluck('name', 'id')->all();
        $material_id = $request->material_id;
        return response()->view('modal-CRUDs.materials.expert-conclusions.create', compact(
            'statuses', 'experts', 'materials', 'options', 'material_id'
        ));
    }

    public function store(Request $request)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'materials' => 'required|array',
            'materials.*' => 'exists:materials,id',
            'options' => 'required|array',
            'result' => 'nullable',
//            'experts' => 'required|array',
//            'experts.*' => 'exists:users,id',
            'file' => 'required',
            'status_id' => 'required|exists:material_conclusion_status,id',
        ]);
        $file_id = null;
        if ($request->hasFile('file')) {
            $file_id = AppHelper::saveDocument('file', 'material-experts');
        }
        $conclusion = MaterialConclusion::create($request->except('file') + [
                'file_id' => $file_id,
            ]);
        $conclusion->materials()->attach($request->materials);
        $conclusion->options()->attach($request->options);
        $conclusion->experts()->attach($request->experts);
        return response()->json([
            'entity' => 'conclusion',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, MaterialConclusion $conclusion)
    {
        $statuses = MaterialConclusionStatus::pluck('title', 'id')->all();
        $options = MaterialConclusionOption::query()->pluck('title', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $materials = $conclusion->materials()->select('materials.*')->pluck('name', 'id')->all();
        $material_id = $request->material_id;
        return response()->view('modal-CRUDs.materials.expert-conclusions.edit', compact(
            'statuses',
            'experts',
            'conclusion', 'materials', 'options', 'material_id'
        ));
    }

    public function update(Request $request, MaterialConclusion $conclusion)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
//        $expertises = $material ? $material->vir_expertises : null;
//        if (count($expertises)) {
//            if (!auth()->user()->hasAccessToExpertise($expertises)) {
//                return response()->json(['errors' => [['you don\'t have access!']]], 422);
//            }
//        } else {
//            abort(403);
//        }
        $request->validate([
            'materials' => 'required|array',
            'materials.*' => 'exists:materials,id',
            'result' => 'required',
//            'experts' => 'required|array',
//            'experts.*' => 'exists:users,id',
            'status_id' => 'required|exists:material_conclusion_status,id',
        ]);
        $file_id = null;
        if ($request->hasFile('file')) {
            $request->merge([
                'file_id' => AppHelper::saveDocument('file', 'materials'),
            ]);
        }
        $conclusion->update($request->all());
        $conclusion->materials()->sync($request->materials);
        $conclusion->options()->sync($request->options);
        $conclusion->experts()->sync($request->experts);
        return response()->json([
            'entity' => 'conclusion',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, MaterialConclusion $conclusion)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $conclusion->delete();
        return response()->json('conclusion', 200);
    }

    public function show(Request $request, MaterialConclusion $conclusion)
    {
        return response()->view('modal-CRUDs.materials.expert-conclusions.show', compact('conclusion'));
    }
}
