<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Material;
use App\Models\Expertise;
use App\Models\MaterialLanguage;
use App\Models\MaterialLanguagesBridge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExportMaterialsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Material::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('file', function (Material $entity) {
                    return AppHelper::showBlade('', $entity->file()->first());
                })
                ->addColumn('expertise_name', function (Material $entity) {
                    return AppHelper::showBlade('', $entity->expertise()->pluck('name')->all());
                })
                ->addColumn('expertise_number', function (Material $entity) {
                    return AppHelper::showBlade('', $entity->expertise()->pluck('number')->all());
                })
                ->addColumn('expertise_types', function (Material $entity) {
                    $expertise = $entity->expertise()->first();
                    return AppHelper::showBlade('', $expertise ? $expertise->types()->pluck('title')->all() : '');
                })
                ->addColumn('expertise_experts', function (Material $entity) {
                    $expertise = $entity->expertise()->first();
                    return AppHelper::showBlade('', $expertise ? $expertise->experts()->select(
                        DB::raw("CONCAT_WS(' ', last_name, name, middle_name) as full_name")
                    )->pluck('full_name')->all() : '');
                })
                ->addColumn('action', function (Material $material) {
                    return AppHelper::indexActionBlade($material, 'materials', 'material');
                })
                ->editColumn('object_type_id', function (Material $entity) {
                    try {
                        return $entity->objectType->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('type_id', function (Material $entity) {
                    try {
                        return $entity->type->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('language_id', function (Material $entity) {
                    $languages = $entity->language()->value('title');
                    if($languages != null){
                        return $languages;
                    }
                    $result = [];
                    $languages = MaterialLanguagesBridge::where('material_id', $entity->id)->get();
                    foreach ($languages as  $key=> $language){
                        $result[$key] = MaterialLanguage::where('id', $language->material_language_id)->value('title');
                    }
                    $languages =  implode(" ", $result);
                    return $languages;
                })
                ->editColumn('status_id', function (Material $entity) {
                    try {
                        return $entity->status->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('creator_id', function (Material $entity) {
                    try {
                        return $entity->creator->vir_full_name;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('created_at', function (Material $entity) {
                    return [
                        'human_format' => $entity->created_at->format('d-m-Y'),
                        'iso8601' => $entity->created_at,
                    ];
                })
                ->toJson();
        }
        return view('materials.export-index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
