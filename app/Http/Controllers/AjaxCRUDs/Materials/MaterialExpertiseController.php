<?php


namespace App\Http\Controllers\AjaxCRUDs\Materials;


use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Contracts\Auth\Access;

class MaterialExpertiseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->exists('material')) {
                $data = Material::find($request->input('material'))->expertise()->where('created', true);
            } else {
                $data = Expertise::query()->where('created', true);
            }
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('subjects', function (Expertise $expertise) {
                    return AppHelper::showBlade('', $expertise->subjects()->pluck('subject_case')->all());
                })
                ->addColumn('type', function (Expertise $expertise) {
                    return AppHelper::showBlade('', $expertise->types()->pluck('title')->all());
                })
                ->addColumn('status', function (Expertise $expertise) {
                    return $expertise->status()->value('title');
                })
                ->addColumn('action', function (Expertise $expertise) {
                    if (auth()->user()->can('expertise-list')) {
                        $modal_show_btn =
                            '<a href="'.route('expertise.show', $expertise->id).
                            '"  title="' . __("Show") .
                            '"><i class="fas fa-search-plus mx-1"></i></a>';
                    } else {
                        $modal_show_btn = '';
                    }

                    if (auth()->user()->can('expertise-edit')) {
                        $redirect_edit_btn =
                            '<a href=' .
                            route("expertise.edit", $expertise->id) .
                            ' title="' .
                            __('Edit') .
                            '"><i class="fas fa-pencil-alt mx-1"></i></a>';
                    } else {
                        $redirect_edit_btn = '';
                    }

                    return $modal_show_btn . $redirect_edit_btn;
                })
                ->filterColumn('created_sat', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(expertise.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('receipt_date', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(expertise.receipt_date, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('start_date', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(expertise.start_date, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('type', function ($query, $keyword) {
                    $sql = "expertise.type_id IN (SELECT id FROM expertise_types as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $sql = "expertise.status_id IN (SELECT id FROM expertise_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        abort(404);
    }

    public function show(Expertise $expertise)
    {
        return response()->view('modal-CRUDs.materials.expertise.show', compact('expertise'));
    }
}
