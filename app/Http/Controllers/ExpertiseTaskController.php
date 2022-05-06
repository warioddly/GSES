<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\ExpertiseTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpertiseTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->addColumn('status', function (ExpertiseTask $task){
                return $task->status()->value('title');
            })
            ->addColumn('expertise', function (ExpertiseTask $task){
                return $task->expertise()->value('number');
            })
            ->addColumn('experts', function (ExpertiseTask $task){
                return $task->experts()->value(DB::raw("GROUP_CONCAT(CONCAT_WS(' ', last_name, name, middle_name) SEPARATOR ', ')"));
            })
            ->addColumn('creator', function (ExpertiseTask $task){
                return $task->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
            })
            ->addColumn('action', function(ExpertiseTask $task) {
                return AppHelper::indexActionBlade($task, 'expertise.tasks', 'expertise-task');
            })
            ->filterColumn('created_at', function ($query, $keyword){
                $sql = "DATE_FORMAT(expertise_tasks.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function ($query, $keyword){
                $sql = "expertise_tasks.status_id IN (SELECT id FROM expertise_task_status as t WHERE t.title LIKE ?)";
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
