<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Report;
use App\Models\ReportStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SettingReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Report::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('status', function (Report $report) {
                    return $report->status()->value('title');
                })
                ->addColumn('action', function (Report $report) {
                    return AppHelper::indexActionBlade($report, 'settings.reports', 'setting-report');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(reports.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $sql = "reports.status_id IN (SELECT id FROM report_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['query', 'template', 'action'])
                ->toJson();
        }

        // $data = Report::orderBy('id','DESC')->paginate(5);
        return view('setting-reports.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = ReportStatus::pluck('title', 'id')->all();
        return view('setting-reports.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'query' => 'required',
            'status_id' => 'required|exists:report_status,id',
        ]);
        Report::create($request->all());
        return redirect()->route('settings.reports.index')
            ->with('success', __('Report created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return view('setting-reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $statuses = ReportStatus::pluck('title', 'id')->all();
        return view('setting-reports.edit', compact('report', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'query' => 'required',
            'status_id' => 'required|exists:report_status,id',
        ]);
        $report->update($request->all());
        return redirect()->route('settings.reports.index')
            ->with('success', __('Report updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('settings.reports.index')
            ->with('success', __('Report deleted successfully'));
    }
}
