<?php


namespace App\Http\Controllers\AjaxCRUDs\Expertise;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\ExpertiseTask;
use App\Models\ExpertiseTaskStatus;
use App\Models\Material;
use App\Models\MaterialArticle;
use App\Models\MaterialConclusion;
use App\Models\MaterialConclusionStatus;
use App\Models\MaterialCourtDecision;
use App\Models\MaterialDecision;
use App\Models\MaterialDecisionStatus;
use App\Models\User;
use App\Models\UserPosition;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpertiseTaskExpertController extends Controller
{
    public function index(Request $request)
    {
        if ($request->exists('expertise'))
            $data = Expertise::find($request->input('expertise'))->tasks();
        else
            $data = ExpertiseTask::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->editColumn('date_start', function (ExpertiseTask $task) {
                return $task->date_start ? $task->date_start->format('d-m-Y') : null; // human readable format
            })
            ->editColumn('date_end', function (ExpertiseTask $task) {
                return $task->date_end ? $task->date_end->format('d-m-Y') : null; // human readable format
            })
            ->addColumn('status', function (ExpertiseTask $task) {
                return $task->status()->value('title');
            })
            ->addColumn('expertise', function (ExpertiseTask $task) {
                return $task->expertise()->value('number');
            })
            ->addColumn('experts', function (ExpertiseTask $task) {
                return $task->experts()->value(DB::raw("GROUP_CONCAT(CONCAT_WS(' ', last_name, name, middle_name) SEPARATOR ', ')"));
            })
            ->addColumn('creator', function (ExpertiseTask $task) {
                return $task->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function (ExpertiseTask $task) {
                return AppHelper::ajaxIndexActionBlade($task, 'expertise.modal.expert-tasks', 'expertise-task');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(expertise_tasks.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $sql = "expertise_tasks.status_id IN (SELECT id FROM expertise_task_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $statuses = ExpertiseTaskStatus::pluck('title', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.expert-tasks.create', compact(
            'statuses', 'experts', 'expertise_id'
        ));
    }

    public function store(Request $request)
    {
        $expertise = Expertise::find($request->input('expertise_id'));
        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'task' => 'required|max:255',
            'date_start' => 'nullable|date_format:d-m-Y|',
            'date_end' => 'nullable|date_format:d-m-Y|after:date_start',
            'comment' => 'nullable',
            'experts' => 'required|array',
            'experts.*' => 'exists:users,id',
            'status_id' => 'required|exists:expertise_task_status,id',
        ]);

        $expert_task = ExpertiseTask::create($request->except('date_start', 'date_end') + [
                'creator_id' => auth()->user()->id,
                'date_start' => date("Y-m-d H:i:s", strtotime($request->date_start)),
                'date_end' => date("Y-m-d H:i:s", strtotime($request->date_end))
            ]);
        $expert_task->experts()->attach($request->experts);
        return response()->json([
            'entity' => 'expert-task',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, ExpertiseTask $expert_task)
    {
        $statuses = ExpertiseTaskStatus::pluck('title', 'id')->all();
//        $experts = User::pluck('name', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.expert-tasks.edit', compact(
            'statuses', 'experts',
            'expert_task', 'expertise_id'
        ));
    }

    public function update(Request $request, ExpertiseTask $expert_task)
    {
        if (!auth()->user()->hasAccessToExpertise($expert_task->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'task' => 'required|max:255',
            'date_start' => 'nullable|date_format:d-m-Y|',
            'date_end' => 'nullable|date_format:d-m-Y|after:date_start',
            'comment' => 'nullable',
            'experts' => 'required|array',
            'experts.*' => 'exists:users,id',
            'status_id' => 'required|exists:expertise_task_status,id',
        ]);
        $expert_task->update($request->except('date_start', 'date_end') + [
                'creator_id' => auth()->user()->id,
                'date_start' => date("Y-m-d H:i:s", strtotime($request->date_start)),
                'date_end' => date("Y-m-d H:i:s", strtotime($request->date_end))
            ]);
        $expert_task->experts()->sync($request->experts);
        return response()->json([
            'entity' => 'expert-task',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, ExpertiseTask $expert_task)
    {

        if (!auth()->user()->hasAccessToExpertise($expert_task->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $expert_task->delete();
        return response()->json('expert-task', 200);
    }

    public function show(ExpertiseTask $expert_task)
    {
        return response()->view('modal-CRUDs.expertise.expert-tasks.show', compact('expert_task'));
    }
}
