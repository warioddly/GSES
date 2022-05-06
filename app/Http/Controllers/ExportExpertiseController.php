<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Expertise;
use App\Models\ExpertiseExpert;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExportExpertiseController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Expertise::query()->where('created', true);
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('subjects', function (Expertise $expertise) {
                    return array('subjects' => $expertise->subjects);
                })
                ->addColumn('types', function (Expertise $expertise) {
                    return array('types' => $expertise->types);
                })
                ->addColumn('experts', function (Expertise $expertise) {
                    return array('experts' => $expertise->experts);
                })
                ->editColumn('contractor_id', function (Expertise $expertise) {
                    try {
                        return $expertise->contractor->vir_full_name;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('sequence_id', function (Expertise $expertise) {
                    try {
                        return $expertise->sequence->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('composition_id', function (Expertise $expertise) {
                    try {
                        return $expertise->composition->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('difficulty_id', function (Expertise $expertise) {
                    try {
                        return $expertise->difficulty->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('status_id', function (Expertise $expertise) {
                    try {
                        return $expertise->status->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('status_reason_id', function (Expertise $expertise) {
                    try {
                        return $expertise->status_reason->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('creator_id', function (Expertise $expertise) {
                    try {
                        return $expertise->creator->vir_full_name;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('article_id', function (Expertise $expertise) {
                    try {
                        return $expertise->article->title;
                    } catch (\Exception $ex) {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($expertise) {
                    return [
                        'human_format' => $expertise->created_at->format('d-m-Y'),
                        'iso8601' => $expertise->created_at,
                    ];
                })
                ->editColumn('receipt_date', function (Expertise $expertise) {
                    try {
                        return [
                            'human_format' => $expertise->receipt_date,
                            'iso8601' => date(DATE_ISO8601, strtotime($expertise->receipt_date)),
                        ];
                    } catch (\Exception $ex) {
                        return [
                            'human_format' => $expertise->receipt_date,
                            'iso8601' => '',
                        ];
                    }
                })
                ->editColumn('start_date', function (Expertise $expertise) {
                    try {
                        return [
                            'human_format' => $expertise->start_date,
                            'iso8601' => date(DATE_ISO8601, strtotime($expertise->start_date)),
                        ];
                    } catch (\Exception $ex) {
                        return [
                            'human_format' => $expertise->start_date,
                            'iso8601' => '',
                        ];
                    }
                })
                ->editColumn('expiration_date', function (Expertise $expertise) {
                    try {
                        return [
                            'human_format' => $expertise->expiration_date,
                            'iso8601' => date(DATE_ISO8601, strtotime($expertise->expiration_date)),
                        ];
                    } catch (\Exception $ex) {
                        return [
                            'human_format' => $expertise->expiration_date,
                            'iso8601' => '',
                        ];
                    }
                })
                ->rawColumns(['types'])
                ->toJson();
        }
        return view('expertise.export-index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
