<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\MarkerWord;
use App\Models\Material;
use App\Models\MaterialWord;
use App\Models\MaterialWordPosition;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MaterialContentController extends Controller
{
    public function content($id, Request $request) {
        $reset = $request->input('reset');
        $material = Material::find($id);
        if ($material->file_text) {
            if ($reset) {
                AppHelper::analyzeContent($material->file_text, $material->id);
                return redirect()->route('materials.content', $id);
            }
            $reset = !MaterialWord::where('material_id', '=', $material->id)->exists();
        }

        return view('materials.content.show', compact('material', 'reset'));
    }

    public function marker_words(Request $request)
    {
        $material_id = $request->input('material_id');
        $type_id = $request->input('type_id');
        $word_count = $request->input('word_count');

        $data = MaterialWord::query()
                ->select('material_words.*')
                ->join('marker_words', 'material_words.word_id', '=', 'marker_words.id')
                ->where(['material_words.material_id' => $material_id])
                ->where(['material_words.type_id' => $type_id]);
        if ($word_count > 0 && $word_count < 4) {
            $data->where(['marker_words.word_count' => $word_count]);
        }

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y'); // human readable format
            })
            ->addColumn('word', function (MaterialWord $material_word){
                return $material_word->word->word;
            })
            ->addColumn('type', function (MaterialWord $material_word){
                return $material_word->type->title;
            })
            ->addColumn('word_type_id', function (MaterialWord $material_word){
                return $material_word->word->type_id;
            })
            ->addColumn('action', function(MaterialWord $material_word) {
                return view('materials.content.index-action', compact('material_word'));
            })
            ->filterColumn('created_at', function ($query, $keyword){
                $sql = "DATE_FORMAT(material_word.created_at, '%d-%m-%Y') like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('word', function ($query, $keyword){
                $sql = "marker_words.word like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('type', function ($query, $keyword){
                $sql = "(material_words.type_id IN (SELECT id FROM marker_word_types as t WHERE t.title LIKE ?) OR
                         marker_words.type_id IN (SELECT id FROM marker_word_types as t WHERE t.title LIKE ?))";
                $query->whereRaw($sql, ["%{$keyword}%", "%{$keyword}%"]);
            })
            ->orderColumn('word', function ($query, $order){
                $query->orderBy('marker_words.word', $order);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function highlight($id, Request $request) {
        $text = Material::find($id)->file_text;
        $material_word_id = $request->input('material_word_id');
        $clear = $request->input('clear');
        if ($clear) {
            return response(['text' => $text, 'lines' => '']);
        }
        $positions = MaterialWordPosition::query()
            ->join('material_words', 'material_word_positions.material_word_id', '=', 'material_words.id')
            ->join('marker_words', 'material_words.word_id', '=', 'marker_words.id')
            ->where('material_words.material_id', '=', $id)
            ->where('material_words.id', '=', $material_word_id)
            ->select(['material_word_positions.position', 'marker_words.word'])
            ->orderBy('material_word_positions.position', 'DESC')
            ->get()->all();

        $text_highlighted = $text;
        $substring_lines = [];
        foreach ($positions as $position) {
            $substring = mb_substr($text, $position->position, mb_strlen($position->word), 'UTF-8');
            $text_highlighted = AppHelper::mb_substr_replace($text_highlighted, '<em class="highlight" id="pos-'.$position->position.'">'.$substring.'</em>', $position->position, mb_strlen($position->word, 'UTF-8'));

            $substring_line = mb_substr($text, max($position->position - 100,0), min(mb_strlen($position->word, 'UTF-8') + 200, mb_strlen($text, 'UTF-8')), 'UTF-8');
            $substring_line = AppHelper::mb_substr_replace($substring_line, '<em class="highlight">'.$substring.'</em>', 100 + (min($position->position - 100,0)), mb_strlen($position->word));
            $substring_lines[]= [$substring_line, $position->position];
        }

        $lines = array_reverse($substring_lines);

        return response(['text' => $text_highlighted, 'lines' => view('materials.content.search-line', compact('lines'))->render()]);
    }

    public function move_word($id, Request $request){
        $material_word_id = $request->input('material_word_id');
        $type_id = $request->input('type_id');
        $word_type_id = $request->input('word_type_id');

        $material_word = MaterialWord::find($material_word_id);

        if ($type_id > 0) {
            $material_word->type_id = $type_id;

            $material_word->save();

            return response(['success'=>true, 'result'=>$material_word]);
        }

        if ($word_type_id > 0) {
            $marker_word = MarkerWord::find($material_word->word_id);

            $marker_word->type_id = $word_type_id;

            $marker_word->save();

            return response(['success'=>true, 'result'=>$marker_word]);
        }
    }
}
