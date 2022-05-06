<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\ExpertiseDecision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpertiseDecisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->addColumn('expertise', function (ExpertiseDecision $decision){
                return $decision->expertise()->value('number');
            })
            ->addColumn('court', function (ExpertiseDecision $decision){
                return $decision->court()->value('title');
            })
            ->addColumn('court_name', function (ExpertiseDecision $decision){
                return $decision->courtName()->value('title');
            })
            ->addColumn('file', function (ExpertiseDecision $decision){
                return AppHelper::showBlade('', $decision->file()->first());
            })
            ->addColumn('creator', function (ExpertiseDecision $decision){
                return $decision->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function(ExpertiseDecision $decision) {
                return AppHelper::indexActionBlade($decision, 'expertise.decisions', 'expertise-decision');
            })
            ->filterColumn('created_at', function ($query, $keyword){
                $sql = "DATE_FORMAT(expertise_decisions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function ($query, $keyword){
                $sql = "DATE_FORMAT(expertise_decisions.date, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword){
                $sql = "expertise_decisions.status_id IN (SELECT id FROM expertise_decision_status as t WHERE t.title LIKE ?)";
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
