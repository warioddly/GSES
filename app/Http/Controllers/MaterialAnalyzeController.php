<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Controllers\Components\DocxConversion;
use App\Http\Controllers\Components\LibreOfficeComponent;
use App\Models\Document;
use App\Models\Expertise;
use App\Models\Material;
use App\Models\MaterialAnalyze;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Madnest\Madzipper\Madzipper;
use Yajra\DataTables\DataTables;

class MaterialAnalyzeController extends Controller
{
    public function analyze()
    {
        return view('materials.analyzes.analyze');
    }

    /**
     * @throws \Exception
     */
    public function extract(Request $request)
    {
        $file = $request->file('file');
        $is_archive = $file->extension() == 'zip';
        $result_array = [];
        if ($is_archive) {
            $file->storeAs('archive_work_place', 'archive.zip', 'public');
            $file = new Filesystem;
            $file->cleanDirectory(storage_path('app/public/archive_files'));            //Отчищаем папку
            $zipper = new Madzipper;
            $zipper->make(storage_path('app/public/archive_work_place/archive.zip'))
                ->extractTo(storage_path('app/public/archive_files'));
            $zipper->close();

            $filePaths = Storage::files('public\archive_files');
            foreach ($filePaths as $path) {
                $file_from_archive = AppHelper::pathToUploadedFile(storage_path("app/" . $path));
                $result_array[] = self::extract_file($file_from_archive) + ['file_path' => $path];
            }
        } else {
            $result_array = self::extract_file($file);
        }
        return response(
            [
                'result_array' => $result_array,
                'is_archive' => $is_archive
            ]);
    }

    /**
     * @param $file
     * @return array
     */

    public static function extract_file($file): array
    {
        $file_name = $file->getRealPath();
        $content = fopen($file_name, 'r');
        $error = false;
        if (in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
            $file_text = AppHelper::tesseractExtractText($content, $file->getClientOriginalName());
            if (preg_match('/<\/html>\s*([\S\s]+)/uim', $file_text, $match)) {
                $error = $match[1];
            }
        } else {
            $file_text = AppHelper::solrExtractText($content, $file->getClientOriginalName());
        }

        return [
            'file_text' => strip_tags($file_text),
            'error' => $error];
    }

    public function search(Request $request) {
        $this->validate($request, [
            'type' => 'required|in:image,text',
            'document' => 'required_if:type,image',
            'text' => 'required_if:type,text',
        ]);

        $material_id = $request->input('material_id');
        $type = $request->input('type');

        if ($type == 'image') {
            $document_id = AppHelper::saveDocument('document', 'analyzes');
            $file = Document::find($document_id);

            if (!$file->isImage()) {
                return back()
                    ->withInput()
                    ->withErrors(['document' => [__('The file is not an image!')]]);
            }
            return redirect()->route('materials.images', [0, 'image_id' => $document_id]);
        } else {
            $text = $request->input('text');
            $filename = Str::random(20) . '.txt';
            $file = AppHelper::createFileFromText($text, $filename);
            $document_id = AppHelper::saveDocument($file, 'analyzes');
        }

        return view('materials.analyzes.result', compact('material_id', 'document_id'));
    }

    public function search_data(Request $request)
    {
        $material_id = $request->input('material_id');
        $document_id = $request->input('document_id');

        if ($request->exists('material_id')) {
            $material = Material::find($material_id);
            $search_text = trim($material->file_text);
            if (empty($search_text)) {
                $file_name = $material->file->getRealPath();
                $content = fopen($file_name, 'r');
                $search_text = AppHelper::solrExtractText($content, $material->file->name);
            }
            if (empty($search_text)) {
                return response([
                    'draw' => 0,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => __('There is no text in the material!'),
                ]);
            }
        } else {
            $document = Document::find($document_id);
            $file_name = $document->getRealPath();
            $content = fopen($file_name, 'r');
            $search_text = AppHelper::solrExtractText($content, $document->name);
            if (empty($search_text)) {
                return response([
                    'draw' => 0,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => __('There is no text in the material!'),
                ]);
            }
        }

        $result = AppHelper::solrSearchMaterial($search_text);

        if (isset($result['error'])) {
            return response([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $result['error'],
            ]);
        }

        $analyzes = [];
        $maxCoefficient = 1;
        foreach ($result as $doc) {
            if (Material::find($doc['id']) && $doc['id'] != $material_id) {
                $analyze = new MaterialAnalyze([
                    'search_material_id' => $material_id ?: null,
                    'search_text' => $search_text,
                    'coefficient' => $doc['score'],
                    'material_id' => $doc['id'],
                    'result' => $doc['content'],
                    'conclusion' => null,
                ]);
                if ($material_id) {
                    $record = MaterialAnalyze::where([
                        'search_material_id' => $material_id,
                        'material_id' => $doc['id'],
                    ])->first();
                    if ($record) {
                        $analyze->id = $record->id;
                        $analyze->conclusion = $record->conclusion;
                        $analyze->coefficient = $record->coefficient;
                        $analyze->search_text = $record->search_text;
                        $analyze->result = $record->result;
                    }
                }

                if ($maxCoefficient < $analyze->coefficient) {
                    $maxCoefficient = $analyze->coefficient;
                }

                $analyzes[] = $analyze;
            }
        }

        return DataTables::of($analyzes)
            ->addIndexColumn()
            ->addColumn('search_material', function (MaterialAnalyze $analyze) {
                return AppHelper::showBlade('', $analyze->search_material()->first());
            })
            ->addColumn('material', function (MaterialAnalyze $analyze) {
                return AppHelper::showBlade('', $analyze->material()->first());
            })
            ->addColumn('coefficient_render', function (MaterialAnalyze $analyze) use ($maxCoefficient) {
                $percent = round($analyze->coefficient * 100 / $maxCoefficient / 1.2, 2);
                $status = $percent >= 60 ? 'success' : ($percent >= 40 ? 'warning' : 'danger');
                return '<div class="progress">
                          <div class="progress-bar progress-bar-' . $status . '" role="progressbar" aria-valuenow="' . $analyze->coefficient . '" aria-valuemin="0" aria-valuemax="' . $maxCoefficient . '" style="width: ' . $percent . '%; min-width: 2em;">
                            ' . round($analyze->coefficient, 4) . '
                          </div>
                        </div>';
            })
            ->addColumn('language', function (MaterialAnalyze $analyze) {
                return $analyze->material && $analyze->material->language ? $analyze->material->language->title : null;
            })
            ->addColumn('action', function (MaterialAnalyze $analyze) {
                $var = uniqid('analyze_');
                return "<script>var $var = " . json_encode($analyze) . "</script>"
                    . "<a href='#' onclick='showAnalyze($var)'>" . __('Show detail') . " <i class='fas fa-arrow-circle-right'></i></a>";
            })
            ->rawColumns(['coefficient_render', 'action'])
            ->toJson();
    }

    public function get_detail(Request $request)
    {
        $analyze = new MaterialAnalyze($request->all());
        $analyze->id = $request->input('id');
        $materials = Material::query()->whereIn('id', [$analyze->search_material_id ?: 0, $analyze->material_id ?: 0])->pluck('name', 'id')->all();
        return view('materials.analyzes.save-result', compact('analyze', 'materials'));
    }

    public function save_analyze(Request $request)
    {

        $this->validate($request, [
            'search_material_id' => 'required',
            'search_text' => 'required',
            'result' => 'nullable',
            'material_id' => 'required',
            'coefficient' => 'nullable',
            'conclusion' => 'nullable',
        ]);
        $data = $request->all();
        $id = $data['id'];

        if ($id) {
            $analyze = MaterialAnalyze::find($id);
            $analyze->update($data);
        } else {
            $analyze = MaterialAnalyze::firstWhere([
                'search_material_id' => $data['search_material_id'],
                'material_id' => $data['material_id']]);
            if ($analyze) {
                $analyze->update($data);
            } else {
                $analyze = MaterialAnalyze::create($data);
            }
        }

        return response()->json($analyze);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MaterialAnalyze::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('search_material', function (MaterialAnalyze $analyze) {
                    return $analyze->search_material()->value('name');
                })
                ->addColumn('material', function (MaterialAnalyze $analyze) {
                    return $analyze->material()->value('name');
                })
                ->addColumn('language', function (MaterialAnalyze $analyze) {
                    return $analyze->material && $analyze->material->language ? $analyze->material->language->title : null;
                })
                ->addColumn('coefficient', function (MaterialAnalyze $analyze) {
                    return $analyze->coefficient . '%';
                })
                ->addColumn('action', function (MaterialAnalyze $analyze) {
                    return AppHelper::indexActionBlade($analyze, 'materials.analyzes', 'material-analyze');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(materials.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('language', function ($query, $keyword) {
                    $sql = "material_analyzes.material_id IN (
                            SELECT id FROM materials WHERE materials.language_id IN (
                            SELECT id FROM material_languages as t WHERE t.title LIKE ?))";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('search_material', function ($query, $keyword) {
                    $sql = "material_analyzes.search_material_id IN (SELECT id FROM materials as t WHERE t.name LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('material', function ($query, $keyword) {
                    $sql = "material_analyzes.material_id IN (SELECT id FROM materials as t WHERE t.name LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // $data = Material::orderBy('id','DESC')->paginate(5);
        return view('materials.analyzes.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials = Material::query()->pluck('name', 'id')->all();
        return view('materials.analyzes.create', compact('materials'));
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
            'search_material_id' => 'required',
            'search_text' => 'required',
            'result' => 'nullable',
            'material_id' => 'required',
            'coefficient' => 'nullable',
            'conclusion' => 'nullable',
        ]);

        $input = $request->all();

        MaterialAnalyze::create($input);

        return redirect()->route('materials.analyzes.index')
            ->with('success', __('Analyze created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analyze = MaterialAnalyze::find($id);
        return view('materials.analyzes.show', compact('analyze'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $analyze = MaterialAnalyze::find($id);
        $materials = Material::query()->pluck('name', 'id')->all();
        return view('materials.analyzes.edit', compact('analyze', 'materials'));
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
        $this->validate($request, [
            'search_material_id' => 'required',
            'search_text' => 'required',
            'result' => 'nullable',
            'material_id' => 'required',
            'coefficient' => 'nullable',
            'conclusion' => 'nullable',
        ]);

        $input = $request->all();

        $analyze = MaterialAnalyze::find($id);
        $analyze->update($input);

        return redirect()->route('materials.analyzes.index')
            ->with('success', __('Analyze created successfully'));
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
