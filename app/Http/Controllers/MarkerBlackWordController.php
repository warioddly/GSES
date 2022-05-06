<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\MarkerBlackWord;
use App\Models\MarkerStatus;
use App\Models\MarkerTerminology;
use App\Models\MaterialLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MarkerBlackWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MarkerBlackWord::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('terminology', function (MarkerBlackWord $marker_black){
                    return $marker_black->terminology()->value('title');
                })
                ->addColumn('language', function (MarkerBlackWord $marker_black){
                    return $marker_black->language()->value('title');
                })
                ->addColumn('status', function (MarkerBlackWord $marker_black){
                    return $marker_black->status()->value('title');
                })
                ->addColumn('creator', function (MarkerBlackWord $marker_black){
                    return $marker_black->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
                })
                ->addColumn('action', function(MarkerBlackWord $marker_black) {
                    return AppHelper::indexActionBlade($marker_black, 'modules.marker_black_words', 'marker-black-word');
                })
                ->filterColumn('created_at', function ($query, $keyword){
                    $sql = "DATE_FORMAT(marker_black_words.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('terminology', function ($query, $keyword){
                    $sql = "marker_black_words.terminology_id IN (SELECT id FROM marker_terminologies as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('language', function ($query, $keyword){
                    $sql = "marker_black_words.language_id IN (SELECT id FROM material_languages as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword){
                    $sql = "marker_black_words.status_id IN (SELECT id FROM marker_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // $data = MarkerBlackWord::orderBy('id','DESC')->paginate(5);
        return view('marker_black_words.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = MarkerStatus::pluck('title', 'id')->all();
        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $terminologies = MarkerTerminology::pluck('title', 'id')->all();
        return view('marker_black_words.create', compact('statuses', 'languages', 'terminologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MarkerBlackWord::create($request->all());
        return redirect()->route('modules.marker_black_words.index')
            ->with('success', __('Report created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param MarkerBlackWord $markerBlackWord
     * @return \Illuminate\Http\Response
     */
    public function show(MarkerBlackWord $markerBlackWord)
    {
        return view('marker_black_words.show', compact('markerBlackWord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MarkerBlackWord $markerBlackWord
     * @return \Illuminate\Http\Response
     */
    public function edit(MarkerBlackWord $markerBlackWord)
    {
        $statuses = MarkerStatus::pluck('title', 'id')->all();
        $languages = MaterialLanguage::pluck('title', 'id')->all();
        $terminologies = MarkerTerminology::pluck('title', 'id')->all();
        return view('marker_black_words.edit', compact('markerBlackWord','statuses', 'languages', 'terminologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param MarkerBlackWord $markerBlackWord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarkerBlackWord $markerBlackWord)
    {
        $markerBlackWord->update($request->all());
        return redirect()->route('modules.marker_black_words.index')
            ->with('success', __('Report updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MarkerBlackWord $markerBlackWord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarkerBlackWord $markerBlackWord)
    {
        $markerBlackWord->delete();
        return redirect()->route('modules.marker_black_words.index')
            ->with('success', __('Report deleted successfully'));
    }
}
