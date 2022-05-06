<?php


namespace App\Http\Controllers\AjaxCRUDs\Materials;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\Material;
use App\Models\MaterialAnalyze;
use App\Models\MaterialConclusion;
use App\Models\MaterialDecision;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class MaterialAnalyzeMaterialController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->all());
        if ($request->exists('material')) {
            $data = Material::find($request->input('material'))->analyzes();
//            dd($data);
        } else {
            $data = MaterialAnalyze::query();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('search_material', function (MaterialAnalyze $analyze) {
                return AppHelper::showBlade('', $analyze->search_material()->first());
            })
            ->addColumn('material', function (MaterialAnalyze $analyze) {
                return AppHelper::showBlade('', $analyze->material()->first());
            })
            ->addColumn('language', function (MaterialAnalyze $analyze) {
                return $analyze->material && $analyze->material->language ? $analyze->material->language->title : null;
            })
            ->addColumn('action', function (MaterialAnalyze $analyze) {
                if (auth()->user()->can('material-analyze-list')) {
                    $modal_show_btn =
                        '<a class="show-crud-modal" href="#" data-url="' . route('material.modal.material-analyzes.show', $analyze->id) .
                        '"  title="' . __("Show") .
                        '"><i class="fas fa-search-plus mx-1"></i></a>';
                } else {
                    $modal_show_btn = '';
                }

                if (auth()->user()->can('material-analyze-edit')) {
                    $redirect_edit_btn =
                        '<a class="show-crud-modal" href="#" data-modal="modal-fullscreen modal-dialog-scrollable" data-url=' .
                        route("material.modal.material-analyzes.edit", $analyze->id) .
                        ' title="' .
                        __('Edit') .
                        '"><i class="fas fa-pencil-alt mx-1"></i></a>';
                } else {
                    $redirect_edit_btn = '';
                }
                if (auth()->user()->can('material-analyze-delete')) {
                    $delete_btn =
                        '<a class="modal-delete" href="#" data-url=' .
                        route("material.modal.material-analyzes.destroy", $analyze->id) .
                        ' title="' .
                        __('Delete') .
                        '"><i class="fas fa-trash-alt mx-1"></i></a>';
                } else {
                    $delete_btn = '';
                }
                return $modal_show_btn . $redirect_edit_btn . $delete_btn;
            })
            ->rawColumns(['coefficient_render', 'action'])
            ->toJson();
    }

    public function edit(MaterialAnalyze $material_analyze)
    {
        $materials = Material::pluck('name', 'id')->all();
        return response()->view('modal-CRUDs.materials.analyze-materials.edit', compact('material_analyze', 'materials'));
    }

    public function update(Request $request, MaterialAnalyze $materialAnalyze)
    {
        $materialAnalyze->update([
            'conclusion' => $request->conclusion,
        ]);
        return response()->json([
            'entity' => 'analyze-material',
            'action' => 'updated',
        ], 200);
    }

    public function show(MaterialAnalyze $material_analyze)
    {
        return response()->view('modal-CRUDs.materials.analyze-materials.show', compact('material_analyze'));
    }

    public function destroy(MaterialAnalyze $material_analyze)
    {
        $material_analyze->delete();
        return response()->json('analyze_material', 200);
    }
}
