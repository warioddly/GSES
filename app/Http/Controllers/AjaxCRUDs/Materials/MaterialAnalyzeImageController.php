<?php


namespace App\Http\Controllers\AjaxCRUDs\Materials;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialAnalyzeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MaterialAnalyzeImageController extends  Controller
{
    public function index(Request $request)
    {
        if ($request->exists('material')) {
            $data = Material::find($request->input('material'))->analyzeImages()->get();
        } else {
            $data = MaterialAnalyzeImage::query();
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
            ->addColumn('image_name', function (MaterialAnalyzeImage $analyze){
                return $analyze->image()->first()->name;
            })
            ->addColumn('material', function (MaterialAnalyzeImage $analyze){
                return AppHelper::showBlade('', $analyze->material()->first());
            })
            ->addColumn('action', function (MaterialAnalyzeImage $analyze) {
                if (auth()->user()->can('material-image-analyze')) {
                    $modal_show_btn =
                        '<a class="show-crud-modal" href="#" data-url="' . route('material.modal.material-analyzes-images.show', $analyze->id) .
                        '"  title="' . __("Show") .
                        '"><i class="fas fa-search-plus mx-1"></i></a>';
                } else {
                    $modal_show_btn = '';
                }

                if (auth()->user()->can('material-image-analyze')) {
                    $redirect_edit_btn =
                        '<a class="show-crud-modal" href="#" data-modal="modal-xl" data-url=' .
                        route("material.modal.material-analyzes-images.edit", $analyze->id) .
                        ' title="' .
                        __('Edit') .
                        '"><i class="fas fa-pencil-alt mx-1"></i></a>';
                } else {
                    $redirect_edit_btn = '';
                }
                if (auth()->user()->can('material-image-analyze')) {
                    $delete_btn =
                        '<a class="modal-delete" href="#" data-url=' .
                        route("material.modal.material-analyzes-images.destroy", $analyze->id) .
                        ' title="' .
                        __('Delete') .
                        '"><i class="fas fa-trash-alt mx-1"></i></a>';
                } else {
                    $delete_btn = '';
                }
                return $modal_show_btn . $redirect_edit_btn . $delete_btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function edit(MaterialAnalyzeImage $material_analyzes_image)
    {
        $materials = Material::pluck('name', 'id')->all();
        return response()->view('modal-CRUDs.materials.analyze-image-materials.edit', compact('material_analyzes_image', 'materials'));
    }

    public function update(Request $request,MaterialAnalyzeImage $material_analyzes_image)
    {
        $material_analyzes_image->update([
            'conclusion' => $request->conclusion,
        ]);
        return response()->json([
            'entity' => 'material_analyze_image',
            'action' => 'updated',
        ], 200);
    }

    public function show(MaterialAnalyzeImage $material_analyzes_image)
    {
        return response()->view('modal-CRUDs.materials.analyze-image-materials.show', compact('material_analyzes_image'));
    }

    public function destroy(MaterialAnalyzeImage $material_analyzes_image)
    {
        $material_analyzes_image->delete();
        return response()->json('material_analyze_image', 200);
    }
}
