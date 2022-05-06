<?php


namespace App\Http\Controllers\AjaxCRUDs\Expertise;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\ExpertisePetition;
use App\Models\ExpertisePetitionStatus;
use App\Models\ExpertisePetitionType;
use App\Models\Material;
use App\Models\MaterialConclusion;
use App\Models\MaterialConclusionStatus;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpertisePetitionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->exists('expertise'))
            $data = Expertise::find($request->input('expertise'))->petitions();
        else
            $data = ExpertisePetition::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->addColumn('expertise', function (ExpertisePetition $petition) {
                return $petition->expertise()->value('number');
            })
            ->addColumn('expert', function (ExpertisePetition $petition) {
                return $petition->expert()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('status', function (ExpertisePetition $petition) {
                return $petition->status()->value('title');
            })
            ->addColumn('type', function (ExpertisePetition $petition) {
                return $petition->type()->value('title');
            })
            ->addColumn('scan', function (ExpertisePetition $conclusion) {
                return AppHelper::showBlade('', $conclusion->scan()->first());
            })
            ->addColumn('creator', function (ExpertisePetition $petition) {
                return $petition->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function (ExpertisePetition $petition) {
                return AppHelper::ajaxIndexActionBlade($petition, 'expertise.modal.petitions', 'expertise-petition');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(expertise_petitions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $sql = "expertise_petitions.status_id IN (SELECT id FROM expertise_petition_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $statuses = ExpertisePetitionStatus::pluck('title', 'id')->all();
        $types = ExpertisePetitionType::pluck('title', 'id')->all();
//        $experts = User::pluck('name', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.petitions.create', compact(
            'statuses', 'experts', 'types', 'expertise_id'
        ));
    }

    public function store(Request $request)
    {
        $expertise = Expertise::find($request->input('expertise_id'));
        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'reason' => 'required',
            'type_id' => 'required|exists:expertise_petition_types,id',
            'status_id' => 'required|exists:expertise_petition_status,id',
            'file' => 'required',
        ]);
        $file_id = null;
        if ($request->hasFile('file')) {
            $file_id = AppHelper::saveDocument('file', 'expertise-petitions');
        }
        ExpertisePetition::create($request->all() + [
                'scan_id' => $file_id,
                'creator_id' => auth()->user()->id,
            ]);
        return response()->json([
            'entity' => 'petition',
            'action' => 'stored',
        ], 200);
    }

    public function edit(Request $request, ExpertisePetition $petition)
    {
        $statuses = ExpertisePetitionStatus::pluck('title', 'id')->all();
        $types = ExpertisePetitionType::pluck('title', 'id')->all();
//        $experts = User::pluck('name', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $expertise_id = $request->expertise_id;
        return response()->view('modal-CRUDs.expertise.petitions.edit', compact(
            'statuses',
            'experts',
            'types',
            'petition', 'expertise_id'
        ));
    }

    /**
     * @param Request $request
     * @param ExpertisePetition $petition
     * @return JsonResponse
     */
    public function update(Request $request, ExpertisePetition $petition): JsonResponse
    {
        if (!auth()->user()->hasAccessToExpertise($petition->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $request->validate([
            'reason' => 'required',
            'type_id' => 'required|exists:expertise_petition_types,id',
            'status_id' => 'required|exists:expertise_petition_status,id',
//            'expert_id' => 'required|exists:users,id',
        ]);
        $request->merge([
            'scan_id' => $request->file_id,
        ]);
        $file_id = null;
        if ($request->hasFile('file')) {
            $request->merge([
                'scan_id' => AppHelper::saveDocument('file', 'materials'),
            ]);
        }
        $petition->update($request->all());
        return response()->json([
            'entity' => 'petition',
            'action' => 'updated',
        ], 200);
    }

    public function destroy(Request $request, ExpertisePetition $petition)
    {
        if (!auth()->user()->hasAccessToExpertise($petition->expertise)) {
            return response()->json(['errors' => [[__("you don't have access!")]]], 422);
        }
        $petition->delete();
        return response()->json('petition', 200);
    }

    public function show(ExpertisePetition $petition)
    {
        return response()->view('modal-CRUDs.expertise.petitions.show', compact('petition'));
    }
}
