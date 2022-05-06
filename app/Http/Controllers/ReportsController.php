<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Components\WordReportGeneratorComponent;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Report::query()->where('status_id', '=', 1);
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('status', function (Report $report){
                    return $report->status()->value('title');
                })
                ->addColumn('action', function(Report $report) {
                    return '<a href="'.route('modules.reports.show', $report->id).'" class="btn btn-primary"><i class="fas fa-arrow-circle-right"></i> '.__('View the report').'</a>';
                })
                ->filterColumn('created_at', function ($query, $keyword){
                    $sql = "DATE_FORMAT(reports.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword){
                    $sql = "reports.status_id IN (SELECT id FROM report_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['query', 'template', 'action'])
                ->toJson();
        }

        // $data = Report::orderBy('id','DESC')->paginate(5);
        return view('reports.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
        $report = Report::find($id);
        $data = DB::select($report->query);

        $spreadsheet = new Spreadsheet();

        eval("$report->template");

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $report->name.'.xlsx"');
        $writer->save('php://output');
    }

    public function downloadXls($data) {

    }

    /**
     * Generate report
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $id = $request->query('id');
        $model = $request->query('model');
        $templateCode = $request->query('code');
        if ($id && $model && $templateCode) {
            $generator = new WordReportGeneratorComponent([
                'relationId' => $id,
                'relationModel' => $model,
                'templateCode' => $templateCode,
            ]);

            $result = $generator->generate();
            if ($result['file'] && $result['document']) {
                return response()->download($result['file'], $result['document']->name);
            }
        }

        return redirect()->back();
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
