<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Contractor;
use App\Models\Expertise;
use App\Models\ExpertiseArticle;
use App\Models\ExpertiseComposition;
use App\Models\ExpertiseConclusion;
use App\Models\ExpertiseCourtName;
use App\Models\ExpertiseDifficulty;
use App\Models\ExpertiseExpert;
use App\Models\ExpertiseMaterial;
use App\Models\ExpertiseSequence;
use App\Models\ExpertiseStatus;
use App\Models\ExpertiseStatusReason;
use App\Models\ExpertiseType;
use App\Models\GraphData;
use App\Models\Material;
use App\Models\Region;
use App\Models\Subject;
use App\Models\User;
use App\Models\UserPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Nette\Utils\Random;
use Yajra\DataTables\DataTables;

class ExpertiseController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if ($request->exists('material')) {

                $data = Material::find($request->input('material'))->expertise();
            } else {
                $data = Expertise::query()->where('created', true);
            }
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y');// human readable format
                })
                ->addColumn('subjects', function (Expertise $expertise) {
                    return AppHelper::showBlade('', $expertise->subjects()->pluck('subject_case')->all());
                })
                ->addColumn('type', function (Expertise $expertise) {
                    return AppHelper::showBlade('', $expertise->types()->pluck('title')->all());
                })
                ->addColumn('contractor', function (Expertise $expertise) {
                    $contractor = Contractor::query()->find($expertise->contractor_id);
                    if ($contractor) {
                        $organ = $contractor->organ()->first();
                        $result = $contractor->last_name . ' ' . $contractor->name . ' ' . $contractor->middle_name;
                        if ($organ) {
                            $result .= $result ? ', ' : '';
                            $result .= $organ->title;
                        }
                        return $result;
                    }
                    return '';
                })
                ->addColumn('experts', function (Expertise $expertise) {
                    return AppHelper::showBlade('', $expertise->experts()->select(
                        DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name")
                    )->pluck('full_name')->all());
                })
                ->addColumn('article', function (Expertise $expertise) {
                    return $expertise->article()->value('title');
                })
                ->addColumn('status', function (Expertise $expertise) {
                    return $expertise->status()->value('title');
                })
                ->addColumn('action', function (Expertise $expertise) {
                    return AppHelper::indexActionBlade($expertise, 'expertise', 'expertise');
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        $experts = User::where('status_id', 1)->whereIn('id', ExpertiseExpert::pluck('expert_id')->all())->get();
        foreach ($experts as $expert) {
            $expert->expertiseTotal = Expertise::whereIn(
                'expertise.id',
                ExpertiseExpert::where('expert_id', $expert->id)->pluck('expertise_id')->all()
            )
            ->join('expertise_status', function ($join) {
                $join->on('expertise_status.id', '=', 'expertise.status_id')
                    ->whereIn(
                        'expertise_status.id',
                        ExpertiseStatus::where('title->ru', 'В обработке')
                            ->orWhere('title->ru', 'В производстве')
                            ->pluck('id')->all()
                    );
            })
            ->count();
        }

        return view('expertise.index', compact('experts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function indexByExpert(Request $request, User $user)
    {
        $data = Expertise::whereIn(
            'id',
            ExpertiseExpert::where('expert_id', $user->id)->pluck('expertise_id')->all()
        );
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->addColumn('subjects', function (Expertise $expertise) {
                return AppHelper::showBlade('', $expertise->subjects()->pluck('subject_case')->all());
            })
            ->addColumn('type', function (Expertise $expertise) {
                return AppHelper::showBlade('', $expertise->types()->pluck('title')->all());
            })
            ->addColumn('contractor', function (Expertise $expertise) {
                $contractor = Contractor::query()->find($expertise->contractor_id);
                if ($contractor) {
                    $organ = $contractor->organ()->first();
                    $result = $contractor->last_name . ' ' . $contractor->name . ' ' . $contractor->middle_name;
                    if ($organ) {
                        $result .= $result ? ', ' : '';
                        $result .= $organ->title;
                    }
                    return $result;
                }
                return '';
            })
            ->addColumn('experts', function (Expertise $expertise) {
                return AppHelper::showBlade('', $expertise->experts()->select(
                    DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name")
                )->pluck('full_name')->all());
            })
            ->addColumn('article', function (Expertise $expertise) {
                return $expertise->article()->value('title');
            })
            ->addColumn('status', function (Expertise $expertise) {
                return $expertise->status()->value('title');
            })
            ->addColumn('action', function (Expertise $expertise) {
                return AppHelper::indexActionBlade($expertise, 'expertise', 'expertise');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Remove old unsaved new expertise
        // Expertise::where(['created'=>false, 'creator_id'=>auth()->id()])->where('created_at', '<', DB::raw('now()-INTERVAL 1 DAY'))->delete();

        $id = old('id');
        if ($id > 0) {
            $expertise = Expertise::find($id);
        } else {
            $expertise = Expertise::create([
                'name' => '',
                'creator_id' => auth()->id(),
                'created' => false
            ]);
        }

        $statusWithReasonId = ExpertiseStatusReason::pluck('status_id', 'id')->all();

        $statusRelation = [];

        foreach ($statusWithReasonId as $key => $value) {
            $statusRelation[] = [$value, $key];

        }
//        $contractors = Contractor::select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $contractors = Contractor::where('cover', false)->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))
            ->get()->pluck('full_name', 'id')->toArray();
        $covers = Contractor::select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->where('cover', true)
            ->get()->pluck('full_name', 'id')->toArray();
        $types = ExpertiseType::pluck('title', 'id')->all();
        $sequences = ExpertiseSequence::pluck('title', 'id')->all();
        $compositions = ExpertiseComposition::pluck('title', 'id')->all();
        $difficulties = ExpertiseDifficulty::pluck('title', 'id')->all();
        $statuses = ExpertiseStatus::ordered()->pluck('title', 'id')->all();
        $subjects = Subject::pluck('subject_case', 'id')->all();
        $articles = ExpertiseArticle::pluck('title', 'id')->all();

        $reasons = ExpertiseStatusReason::pluck('title', 'id')->all();
        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        if ($request->has('material_id') && !ExpertiseMaterial::where('material_id', $request->material_id)->where('expertise_id', $expertise->id)->exists()) {
            ExpertiseMaterial::create([
                'expertise_id' => $expertise->id,
                'material_id' => $request->material_id,
            ]);
        }

        return view('expertise.create', compact('expertise',
            'contractors', 'types', 'sequences', 'compositions', 'difficulties',
            'statuses', 'reasons', 'experts', 'statusRelation', 'subjects', 'articles', 'covers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');

        $this->validate($request, [
            'name' => 'required',
            'number' => 'nullable|unique:expertise,number',
            'case_number' => 'nullable',
            'reason' => 'nullable',
            'decree_reg_number' => 'nullable',
            'receipt_date' => 'nullable|date_format:d-m-Y',
            'start_date' => 'nullable|date_format:d-m-Y|after_or_equal:receipt_date',
            'expiration_date' => 'nullable|date_format:d-m-Y|after_or_equal:start_date',
            'contractor_id' => 'nullable',
            'cover_id' => 'nullable',
            'sequence_id' => 'nullable',
            'composition_id' => 'nullable',
            'difficulty_id' => 'nullable',
            'resolution' => 'nullable',
            'resolution_id' => 'nullable',
            'conclusion' => 'nullable',
            'conclusion_id' => 'nullable',
            'comment' => 'nullable',
            'status_id' => 'nullable',
            'status_reason_id' => 'nullable',
            'questions' => 'nullable',
            'creator_id' => 'nullable',
            'types' => 'nullable',
            'subjects_ids' => 'nullable',
            'experts' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->composition_id == 2 || $request->composition_id == 4) {
                        if (count($value) < 2) {
//                            $fail(__('This composition requires more that 2 experts'));
                        }
                    }
                },
            ]
        ]);

        $input = $request->all();

        try {
            $graphData = GraphData::where('year', date('Y'))->get()->toArray()[0];
        }
        catch (\Exception $exception){
            $oldYearData = GraphData::where('year', date('Y') - 1)->get()->toArray()[0];
            GraphData::where('year', date('Y') - 2)->update($oldYearData);
            GraphData::where('year', date('Y') - 1)->update([
                'year' => date('Y'),
                'Бишкек' => 0,
                'Ош' => 0,
                'Ошская область' => 0,
                'Баткенская область' => 0,
                'Жалал-Абадская область' => 0,
                'Чуйская область' => 0,
                'Нарынская область' => 0,
                'Иссык-кульская область' => 0,
                'Таласская область' => 0,
            ]);
        }

        $contractor = Contractor::whereId($input['contractor_id'])->get()->toArray()[0];
        $contractorRegion = Region::whereId($contractor['region_id'])->pluck('region')->toArray()[0];

        $graphData['year'] = date('Y');
        $graphData[$contractorRegion] = $graphData[$contractorRegion] + 1;

        $graph = GraphData::where('year', date('Y'))->first();
        $graph->update($graphData);

        $input['resolution_id'] = AppHelper::saveDocument('resolution', 'expertise');
//        $input['conclusion_id'] = AppHelper::saveDocument('conclusion', 'expertise');
        $input['creator_id'] = auth()->id();
        $input['created'] = true;
        $input['created_at'] = Carbon::now();
        $input['updated_at'] = Carbon::now();
        $expertise = Expertise::find($id);
        $expertise->subjects()->attach($request->subject_ids);
        $expertise->update($input);

        $expertise->types()->sync($request->input('types'));

        $expertise->vir_experts()->sync($request->input('experts'));
//        $expertise->assignExperts($request->input('experts'));

        $docId = AppHelper::saveDocument('conclusion', 'expertise');
        if ($docId && $expertise) {
            ExpertiseConclusion::create([
                'expertise_id' => $expertise->id,
                'document_id' => $docId,
            ]);
        }

        return redirect()->route('expertise.index')
            ->with('success', __('Expertise created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expertise = Expertise::find($id);

        return view('expertise.show', compact('expertise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statusWithReasonId = ExpertiseStatusReason::pluck('status_id', 'id')->all();

        $statusRelation = [];

        foreach ($statusWithReasonId as $key => $value) {
            $statusRelation[] = [$value, $key];

        }
        $expertise = Expertise::find($id);
        $contractor = $expertise->contractor()->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $cover = $expertise->cover()->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();

        $contractors = Contractor::where('cover', false)->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))
            ->get()->pluck('full_name', 'id')->toArray();
        $covers = Contractor::select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->where('cover', true)
            ->get()->pluck('full_name', 'id')->toArray();

        $types = ExpertiseType::pluck('title', 'id')->all();
        $sequences = ExpertiseSequence::pluck('title', 'id')->all();
        $compositions = ExpertiseComposition::pluck('title', 'id')->all();
        $difficulties = ExpertiseDifficulty::pluck('title', 'id')->all();
        $statuses = ExpertiseStatus::pluck('title', 'id')->all();
        $reasons = ExpertiseStatusReason::pluck('title', 'id')->all();
        $articles = ExpertiseArticle::pluck('title', 'id')->all();

        $pos = UserPosition::where(['code' => 'EXPERT'])->value('id');
        $experts = User::where(['position_id' => $pos])->select('id', DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name"))->pluck('full_name', 'id')->all();
        $subjects = Subject::pluck('subject_case', 'id')->all();
        $conclusions = ExpertiseConclusion::where('expertise_id', $id)->get();

        return view('expertise.edit', compact('expertise', 'contractor', 'contractors', 'cover', 'covers',
            'types', 'sequences', 'compositions', 'difficulties',
            'statuses', 'reasons', 'experts', 'statusRelation', 'subjects', 'articles', 'conclusions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $expertise = Expertise::find($id);
        $old_contractor = $expertise->contractor_id;

        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return redirect()->back()->with('accessError', __('you do not access!'));
        }
        $this->validate($request, [
            'name' => 'required',
            'number' => 'nullable|unique:expertise,number,' . $id,
            'case_number' => 'nullable',
            'reason' => 'nullable',
            'decree_reg_number' => 'nullable',
            'receipt_date' => 'nullable|date_format:d-m-Y',
            'start_date' => 'nullable|date_format:d-m-Y|after_or_equal:receipt_date',
            'expiration_date' => 'nullable|date_format:d-m-Y|after:start_date',
            'contractor_id' => 'nullable',
            'cover_id' => 'nullable',
            'types' => 'nullable',
            'sequence_id' => 'nullable',
            'composition_id' => 'nullable',
            'difficulty_id' => 'nullable',
            'resolution' => 'nullable',
            'resolution_id' => 'nullable',
            'conclusion' => 'nullable',
            'conclusion_id' => 'nullable',
            'comment' => 'nullable',
            'status_id' => 'nullable',
            'status_reason_id' => 'nullable',
            'questions' => 'nullable',
            'creator_id' => 'nullable',
            'experts' => 'required',
            'subjects_ids' => 'nullable',
        ]);
        $input = $request->all();

        // Upload file
        if (empty($input['resolution_id'])) {
            $input['resolution_id'] = AppHelper::saveDocument('resolution', 'expertise');
        }

        $expertise->subjects()->sync($request->subject_ids);
        $expertise->update($input);

        $expertise->types()->sync($request->input('types'));
        $expertise->vir_experts()->sync($request->input('experts'));
//        $expertise->assignExperts($request->input('experts'));

        if ($expertise && (empty($input['conclusion_id']) || $request->hasFile('conclusion'))) {
            $finded = ExpertiseConclusion::query()
                ->where('expertise_id', $expertise->id)
                ->whereRelation('document', 'creator_id', auth()->id())
                ->first();
            if ($finded) {
                AppHelper::deleteDocument($finded->document_id);
            }

            $docId = AppHelper::saveDocument('conclusion', 'expertise');
            if ($docId) {
                ExpertiseConclusion::create([
                    'expertise_id' => $expertise->id,
                    'document_id' => $docId,
                ]);
            }
        }

        if($old_contractor != $input['contractor_id']){
            try {
                $graphData = GraphData::where('year', date('Y'))->get()->toArray()[0];
            }
            catch (\Exception $exception){
                $oldYearData = GraphData::where('year', date('Y') - 1)->get()->toArray()[0];
                GraphData::where('year', date('Y') - 2)->update($oldYearData);
                GraphData::where('year', date('Y') - 1)->update([
                    'year' => date('Y'),
                    'Бишкек' => 0,
                    'Ош' => 0,
                    'Ошская область' => 0,
                    'Баткенская область' => 0,
                    'Жалал-Абадская область' => 0,
                    'Чуйская область' => 0,
                    'Нарынская область' => 0,
                    'Иссык-кульская область' => 0,
                    'Таласская область' => 0,
                ]);
            }

            $contractor = Contractor::whereId($old_contractor)->get()->toArray()[0];
            $contractorRegion = Region::whereId($contractor['region_id'])->pluck('region')->toArray()[0];
            $graphData['year'] = date('Y');

            if($graphData[$contractorRegion] != 0){
                $graphData[$contractorRegion] = $graphData[$contractorRegion] - 1;
            }

            $graph = GraphData::where('year', date('Y'))->first();
            $graph->update($graphData);

            $graphData = GraphData::where('year', date('Y'))->get()->toArray()[0];
            $contractor = Contractor::whereId($input['contractor_id'])->get()->toArray()[0];
            $contractorRegion = Region::whereId($contractor['region_id'])->pluck('region')->toArray()[0];

            $graphData['year'] = date('Y');
            $graphData[$contractorRegion] = $graphData[$contractorRegion] + 1;
            $graph->update($graphData);
        }

        return redirect()->route('expertise.index')
            ->with('success', __('Expertise updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expertise = Expertise::find($id);
        if (!auth()->user()->hasAccessToExpertise($expertise)) {
            return redirect()->back()->with('accessError', __('you do not access!'));
        }
        Expertise::find($id)->delete();
        return redirect()->route('expertise.index')
            ->with('success', __('Expertise deleted successfully'));
    }
}
