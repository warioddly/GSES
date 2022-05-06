<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Panoscape\History\History;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model_type = $request->input('model_type');
        $model_id = $request->input('model_id');
        if ($model_type == 'App\\Models\\User')
            $data = $model_type::find($model_id)->operations();
        else
            $data = $model_type::find($model_id)->histories();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('performed_at', function ($request) {
                return $request->performed_at->format('d-m-Y'); // human readable format
            })
            ->editColumn('message', function (History $history) {
                $strArray = explode(' ', $history->message);
                $actionStr = trans('panoscape::history.pano_' . $strArray[0]);
                $ModelStr = trans('panoscape::history.' . $strArray[1]);

                return $actionStr . ' ' . $ModelStr . ' ' . str_replace([$strArray[0], $strArray[1]], '', $history->message);
            })
            ->addColumn('user', function (History $history) {
                if ($history->user()) {
                    return $history->user()->last_name . ' ' . $history->user()->name . ' ' . $history->user()->middle_name;
                } else {
                    return '';
                }
            })
            ->addColumn('meta', function (History $history) {
                return view('uitypes.history_meta', compact('history'));
            })
            ->filterColumn('performed_at', function ($query, $keyword) {
                $sql = "DATE_FORMAT(performed_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
