<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\MarkerWord;
use App\Models\MarkerWordType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MarkerWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = MarkerWord::where('is_show', true)->orWhereHas('materialWords', function ($q){
            return $q->where('type_id', 3);
        });
        if ($request->ajax()) {
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('type', function (MarkerWord $marker_word) {
                    return $marker_word->type()->value('title');
                })
                ->addColumn('declensions', function (MarkerWord $marker_word) {
                    return view('marker_words.index-declensions', compact('marker_word'));
                })
                ->addColumn('action', function (MarkerWord $marker_word) {
                    return AppHelper::indexActionBlade($marker_word, 'modules.marker_words', 'marker-word');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(marker_words.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // $data = MarkerWord::orderBy('id','DESC')->paginate(5);
        return view('marker_words.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = MarkerWordType::pluck('title', 'id')->all();
        return view('marker_words.create', compact('types'));
    }

    public function getDeclensions(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $marker_words = MarkerWord::orderby('word', 'asc')->select('id', 'word')->limit(10)->get();
        } else {
            $marker_words = MarkerWord::orderby('word', 'asc')->select('id', 'word')->where('word', 'like', '%' . $search . '%')->limit(10)->get();
        }

        $response = array();
        foreach ($marker_words as $marker_word) {
            $response[] = array(
                "id" => $marker_word->id,
                "text" => $marker_word->word
            );
        }
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_id' => 'required',
            'word' => 'required|unique:marker_words,word',
        ]);
        $data = $request->all();
        $data['word'] = preg_replace('/ +/uim', ' ', trim($data['word']));
        $data['word_count'] = count(explode(' ', $data['word']));
        $data['is_show'] = true;
        $marker_word = MarkerWord::create($data);

        $marker_word->declensions()->attach($request->input('declensions'));

        return redirect()->route('modules.marker_words.index')
            ->with('success', __('Marker word created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param MarkerWord $marker_word
     * @return \Illuminate\Http\Response
     */
    public function show(MarkerWord $marker_word)
    {
        return view('marker_words.show', compact('marker_word'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MarkerWord $marker_word
     * @return \Illuminate\Http\Response
     */
    public function edit(MarkerWord $marker_word)
    {
        $types = MarkerWordType::pluck('title', 'id')->all();
        $declensions = $marker_word->declensions()->pluck('word', 'marker_words.id')->all();
        return view('marker_words.edit', compact('marker_word', 'types', 'declensions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MarkerWord $marker_word
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarkerWord $marker_word)
    {
        $data = $request->all();
        $this->validate($request, [
            'type_id' => 'required',
            'word' => 'required|unique:marker_words,word,' . $marker_word->id,
        ]);

        $data['word'] = preg_replace('/ +/uim', ' ', trim($data['word']));
        $data['word_count'] = count(explode(' ', $data['word']));

        $marker_word->update($data);

        $marker_word->declensions()->sync($request->input('declensions'));

        return redirect()->route('modules.marker_words.index')
            ->with('success', __('Marker word updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MarkerWord $marker_word
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarkerWord $marker_word)
    {
        $marker_word->delete();
        return redirect()->route('modules.marker_words.index')
            ->with('success', __('Marker word deleted successfully'));
    }
}
