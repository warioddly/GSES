<?php


namespace App\Http\Controllers\AjaxCRUDs\Expertise;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\ExpertiseCourt;
use App\Models\ExpertiseCourtName;
use App\Models\ExpertiseDecision;
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

class ExpertiseJudgesDecisionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->exists('expertise'))
            $data = Expertise::find($request->input('expertise'))->decisions();
        else
            $data = ExpertiseDecision::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->editColumn('date', function ($request) {
                return $request->date->format('d-m-Y'); // human readable format
            })
            ->addColumn('expertise', function (ExpertiseDecision $decision) {
                return $decision->expertise()->value('number');
            })
            ->addColumn('court', function (ExpertiseDecision $decision) {
                return $decision->court()->value('title');
            })
            ->addColumn('court_name', function (ExpertiseDecision $decision) {
                return $decision->courtName()->value('title');
            })
            ->addColumn('file', function (ExpertiseDecision $decision) {
                return AppHelper::showBlade('', $decision->file()->first());
            })
            ->addColumn('creator', function (ExpertiseDecision $decision) {
                return $decision->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function (ExpertiseDecision $decision) {
                return AppHelper::ajaxIndexActionBlade($decision, 'expertise.modal.decisions', 'material-court-decision');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(expertise_decisions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function ($query, $keyword) {
                $sql = "DATE_FORMAT(expertise_decisions.date, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $sql = "expertise_decisions.status_id IN (SELECT id FROM expertise_decision_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $courtCourtNameId = ExpertiseCourtName::pluck('court_id', 'id')->all();

        $courtRelation = [];
        foreach ($courtCourtNameId as $key => $value) {
            $courtRelation[] = [$value, $key];

        }
        $courtDecision = ExpertiseCourt::pluck('title', 'id')->all();
        $courtNames = ExpertiseCourtName::pluck('title', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.judges-decision.create', compact(
            'courtDecision', 'courtNames', 'courtRelation', 'expertise_id'
        ));
    }

    public function store(Request $request)
    {
        $expertise = Expertise::find($request->input('expertise_id'));
        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'court_id' => 'required|exists:expertise_courts,id',
            'court_name_id' => 'required|exists:expertise_court_names,id',
            'date' => 'required|date_format:d-m-Y',
            'file' => 'required',
        ]);
        $file_id = null;
        if ($request->hasFile('file')) {
            $file_id = AppHelper::saveDocument('file', 'expertise-decisions');
        }
        ExpertiseDecision::create($request->except('date', 'file') + [
                'creator_id' => auth()->user()->id,
                'file_id' => $file_id,
                'date' => date("Y-m-d H:i:s", strtotime($request->date))
            ]);
        return response()->json([
            'entity' => 'decision',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, ExpertiseDecision $decision)
    {
        $courtCourtNameId = ExpertiseCourtName::pluck('court_id', 'id')->all();

        $courtRelation = [];
        foreach ($courtCourtNameId as $key => $value) {
            $courtRelation[] = [$value, $key];

        }
        $courtDecision = ExpertiseCourt::pluck('title', 'id')->all();
        $courtNames = ExpertiseCourtName::pluck('title', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.judges-decision.edit', compact(
            'courtNames', 'courtDecision', 'courtRelation',
            'decision', 'expertise_id'
        ));
    }

    public function update(Request $request, ExpertiseDecision $decision)
    {
        if (!auth()->user()->hasAccessToExpertise($decision->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'court_id' => 'required|exists:expertise_courts,id',
            'court_name_id' => 'required|exists:expertise_court_names,id',
            'date' => 'required|date_format:d-m-Y',
        ]);
        if ($request->hasFile('file')) {
            $request->merge([
                'file_id' => AppHelper::saveDocument('file', 'materials'),
            ]);
        }
        $decision->update($request->except('date') + [
                'creator_id' => auth()->user()->id,
                'date' => date("Y-m-d H:i:s", strtotime($request->date)),
            ]);
        return response()->json([
            'entity' => 'decision',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, ExpertiseDecision $decision)
    {
        if (!auth()->user()->hasAccessToExpertise($decision->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $decision->delete();
        return response()->json('decision', 200);
    }

    public function show(ExpertiseDecision $decision)
    {
        return response()->view('modal-CRUDs.expertise.judges-decision.show', compact('decision'));
    }
}
