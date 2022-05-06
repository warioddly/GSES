<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\ExpertisePetition;
use App\Models\MaterialConclusion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpertisePetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->addColumn('expertise', function (ExpertisePetition $petition){
                return $petition->expertise()->value('number');
            })
            ->addColumn('expert', function (ExpertisePetition $petition){
                return $petition->expert()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('status', function (ExpertisePetition $petition){
                return $petition->status()->value('title');
            })
            ->addColumn('type', function (ExpertisePetition $petition){
                return $petition->type()->value('title');
            })
            ->addColumn('scan', function (ExpertisePetition $conclusion){
                return AppHelper::showBlade('', $conclusion->scan()->first());
            })
            ->addColumn('creator', function (ExpertisePetition $petition){
                return $petition->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function(ExpertisePetition $petition) {
                return AppHelper::indexActionBlade($petition, 'expertise.petitions', 'expertise-petition');
            })
            ->filterColumn('created_at', function ($query, $keyword){
                $sql = "DATE_FORMAT(expertise_petitions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword){
                $sql = "expertise_petitions.status_id IN (SELECT id FROM expertise_petition_status as t WHERE t.title LIKE ?)";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
