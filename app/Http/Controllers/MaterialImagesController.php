<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Document;
use App\Models\Material;
use App\Models\MaterialAnalyze;
use App\Models\MaterialAnalyzeImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MaterialImagesController extends Controller
{
    public function images($id, Request $request){
        $material_id = $id;
        $material = Material::find($id);
        $file = $material ? $material->file()->first() : null;
        $image_id = $request->input('image_id');
        if ($image_id) {
            $image = Document::find($image_id);
            return view('materials.images.result-images', compact('material_id', 'image'));
        }
        if ($material && $material->images()->count()) {
            return view('materials.images.select-images', compact('material'));
        }
        elseif ($file && $file->isImage()) {
            $image = $file;
            return view('materials.images.result-images', compact('material_id', 'image'));
        }
        else {
            return view('materials.images.select-images', compact('material'));
        }
    }

    public function search($id, Request $request){

        $material = Material::find($id);

        $image_id = $request->input('image_id');

        if (empty($image_id)) {
            return response([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => __('Image not found!'),
            ]);
        }

        $image = Document::find($image_id);

        $images = AppHelper::solrSearchImage(route('view-file', $image->name_uuid));

        if (isset($images['error'])) {
            // dump($images);
            return response([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $images['error'],
            ]);
        }

        $data = [];
        $maxCoefficient = 0;
        $minCoefficient = -1;
        foreach ($images as $item) {
            $old = MaterialAnalyzeImage::where(['search_image_id' => $image->id, 'image_id' => $item['image']->id])->first();
            if ($old) {
                $row = $old;
            }
            else {
                $row= new MaterialAnalyzeImage([
                    'search_image_id' => $image->id,
                    'coefficient' => floatval($item['score']),
                    'image_id' => $item['image']->id,
                    'size' => $item['image']->getSize(),
                    'conclusion' => null,
                ]);
            }

            if ($row->material()->value('materials.id') != $row->searchMaterial()->value('materials.id')) {
                if ($maxCoefficient < $row->coefficient) {
                    $maxCoefficient = $row->coefficient;
                }
                if ($minCoefficient > $row->coefficient || $minCoefficient == -1) {
                    $minCoefficient = $row->coefficient;
                }
                $data[]= $row;
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('search_image', function (MaterialAnalyzeImage $analyze){
                return AppHelper::showBlade('', $analyze->searchImage()->first());
            })
            ->addColumn('search_material', function (MaterialAnalyzeImage $analyze){
                return AppHelper::showBlade('', $analyze->searchMaterial()->first());
            })
            ->addColumn('image', function (MaterialAnalyzeImage $analyze){
                return AppHelper::showBlade('', $analyze->image()->first());
            })
            ->addColumn('coefficient_render', function (MaterialAnalyzeImage $analyze) use ($maxCoefficient, $minCoefficient) {
                $total  = round($maxCoefficient - $minCoefficient, 4);
                if ($minCoefficient > 10)
                    $total += 80;
                elseif ($minCoefficient > 0)
                    $total += 20;
                $coefficient = $maxCoefficient - $analyze->coefficient;
                if ($total > 0)
                    $percent = round($coefficient * 100 / $total, 2);
                elseif ($minCoefficient > 0)
                    $percent = 80;
                else
                    $percent = 100;

                $status = $percent >= 60 ? 'success' : ($percent >= 40 ? 'warning' : 'danger');
                return '<div class="progress">
                          <div class="progress-bar progress-bar-'.$status.'" role="progressbar" aria-valuenow="'.$analyze->coefficient.'" aria-valuemin="0" aria-valuemax="'.$maxCoefficient.'" style="width: '.$percent.'%; min-width: 2em;">
                            '.round($analyze->coefficient, 4).'
                          </div>
                        </div>';
            })
            ->addColumn('image_name', function (MaterialAnalyzeImage $analyze){
                return $analyze->image()->first()->name;
            })
            ->addColumn('material', function (MaterialAnalyzeImage $analyze){
                return AppHelper::showBlade('', $analyze->material()->first());
            })
            ->addColumn('action', function(MaterialAnalyzeImage $analyze) {
                $var = uniqid('analyze_');
                return "<script>var $var = ".json_encode($analyze)."</script>"
                    . "<a href='#' onclick='showAnalyze($var)'>".__('Show detail')." <i class='fas fa-arrow-circle-right'></i></a>";
            })
            ->rawColumns(['coefficient_render', 'action'])
            ->toJson();
    }

    public function get_detail($id, Request $request) {
        $analyze = new MaterialAnalyzeImage($request->all());
        $analyze->id = $request->input('id');
        $materials = Material::query()->whereIn('id', [$analyze->material()->value('materials.id')?:0, $analyze->searchMaterial()->value('materials.id')?:0])->pluck('name', 'id')->all();
        return view('materials.images.save-result', compact('analyze', 'materials'));
    }

    public function save_analyze($id, Request $request) {

        $this->validate($request, [
            'search_image_id' => 'required',
            'image_id' => 'required',
            'coefficient' => 'nullable',
            'conclusion' => 'nullable',
        ]);
        $data = $request->all();
        $id = $data['id'];

        if ($id) {
            $analyze = MaterialAnalyzeImage::find($id);
            $analyze->update($data);
        }
        else {
            $analyze = MaterialAnalyzeImage::firstWhere([
                'search_image_id' => $data['search_image_id'],
                'image_id' => $data['image_id']]);
            if ($analyze) {
                $analyze->update($data);
            }
            else {
                $analyze = MaterialAnalyzeImage::create($data);
            }
        }

        return response()->json($analyze);
    }
}
