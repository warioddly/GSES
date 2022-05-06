<?php


namespace App\Http\Controllers\AjaxCRUDs\Materials;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialArticle;
use App\Models\MaterialConclusion;
use App\Models\MaterialConclusionStatus;
use App\Models\MaterialCourtDecision;
use App\Models\MaterialDecision;
use App\Models\MaterialDecisionStatus;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaterialJudgesDecisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->exists('material'))
            $data = Material::find($request->input('material'))->decisions();
        else
            $data = MaterialDecision::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->editColumn('date', function ($request) {
                return $request->date->format('d-m-Y'); // human readable format
            })
            ->addColumn('material', function (MaterialDecision $decision) {
                return $decision->material()->value('name');
            })
            ->addColumn('article', function (MaterialDecision $decision) {
                return $decision->article()->value('title');
            })
            ->addColumn('court_decision', function (MaterialDecision $decision) {
                return $decision->courtDecision()->value('title');
            })
            ->addColumn('status', function (MaterialDecision $decision) {
                return $decision->status()->value('title');
            })
            ->addColumn('creator', function (MaterialDecision $decision) {
                return $decision->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function (MaterialDecision $decision) {
                return AppHelper::AjaxIndexActionBlade($decision, 'material.modal.decisions', 'material-court-decision');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(material_decisions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function ($query, $keyword) {
                $sql = "DATE_FORMAT(material_decisions.date, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $sql = "material_decisions.status_id IN (SELECT id FROM material_decision_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $articles = MaterialArticle::pluck('title', 'id')->all();
        $courtDecision = MaterialCourtDecision::pluck('title', 'id')->all();
        $statuses = MaterialDecisionStatus::pluck('title', 'id')->all();
        $material_id = $request->material_id;
        return response()->view('modal-CRUDs.materials.judges-decision.create', compact(
            'statuses', 'articles', 'courtDecision', 'material_id'
        ));
    }

    public function store(Request $request)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [['you don\'t have access!']]], 422);
        }
       $request->validate( [
            'article_id' => 'required|exists:material_articles,id',
            'court_decision_id' => 'required|exists:material_court_decisions,id',
            'status_id' => 'required|exists:material_decision_status,id',
            'date' => 'required|date_format:d-m-Y',
        ]);

        MaterialDecision::create($request->except('date') + [
                'creator_id' => auth()->user()->id,
                'date' => date("Y-m-d H:i:s", strtotime($request->date))
            ]);
        return response()->json([
            'entity' => 'decision',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, MaterialDecision $decision)
    {
        $articles = MaterialArticle::pluck('title', 'id')->all();
        $courtDecision = MaterialCourtDecision::pluck('title', 'id')->all();
        $statuses = MaterialDecisionStatus::pluck('title', 'id')->all();
        $material_id = $request->material_id;
        return response()->view('modal-CRUDs.materials.judges-decision.edit', compact(
            'statuses', 'articles', 'courtDecision',
            'decision', 'material_id'
        ));
    }

    public function update(Request $request, MaterialDecision $decision)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [['you don\'t have access!']]], 422);
        }
       $request->validate([
            'article_id' => 'required|exists:material_articles,id',
            'court_decision_id' => 'required|exists:material_court_decisions,id',
            'status_id' => 'required|exists:material_decision_status,id',
            'date' => 'required|date_format:d-m-Y',
        ]);
        $decision->update($request->except('date') + [
                'creator_id' => auth()->user()->id,
                'date' => date("Y-m-d H:i:s", strtotime($request->date))
            ]);
        return response()->json([
            'entity' => 'decision',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, MaterialDecision $decision)
    {
        $material = Material::find($request->input('material_id'));
        if (!auth()->user()->hasAccessToMaterial($material, 'update')) {
            return response()->json(['errors' => [['you don\'t have access!']]], 422);
        }
        $decision->delete();
        return response()->json('decision', 200);
    }

    public function show(Request $request, MaterialDecision $decision)
    {
        return response()->view('modal-CRUDs.materials.judges-decision.show', compact('decision'));
    }
}
