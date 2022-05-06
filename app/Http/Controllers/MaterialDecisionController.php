<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\MaterialDecision;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MaterialDecisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->addColumn('material', function (MaterialDecision $decision){
                return $decision->material()->value('name');
            })
            ->addColumn('article', function (MaterialDecision $decision){
                return $decision->article()->value('title');
            })
            ->addColumn('court_decision', function (MaterialDecision $decision){
                return $decision->courtDecision()->value('title');
            })
            ->addColumn('status', function (MaterialDecision $decision){
                return $decision->status()->value('title');
            })
            ->addColumn('creator', function (MaterialDecision $decision){
                return $decision->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function(MaterialDecision $decision) {
                return AppHelper::indexActionBlade($decision, 'expertise.decisions', 'expertise-decision');
            })
            ->filterColumn('created_at', function ($query, $keyword){
                $sql = "DATE_FORMAT(material_decisions.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function ($query, $keyword){
                $sql = "DATE_FORMAT(material_decisions.date, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword){
                $sql = "material_decisions.status_id IN (SELECT id FROM material_decision_status as t WHERE t.title LIKE ?)";
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
