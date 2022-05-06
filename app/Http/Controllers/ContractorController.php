<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\ContractorOrgan;
use App\Models\ContractorType;
use App\Models\Expertise;
use App\Models\Contractor;
use App\Models\GraphData;
use App\Models\MaterialLanguage;
use App\Models\MaterialObjectType;
use App\Models\MaterialStatus;
use App\Models\MaterialType;
use App\Models\MaterialTypeObjectType;
use App\Models\Region;
use App\Models\RegionDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contractor::query();
            if ($request->query('searchText')) {
                $data
                    ->where('last_name', 'like', '%' . $request->query('searchText') . '%')
                    ->orWhere('name', 'like', '%' . $request->query('searchText') . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->query('searchText') . '%');
            }

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('type', function (Contractor $contractor) {
                    return $contractor->type()->value('title');
                })
                ->addColumn('organ', function (Contractor $contractor) {
                    return $contractor->organ()->value('title');
                })
                ->addColumn('creator', function (Contractor $contractor) {
                    return $contractor->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
                })
                ->addColumn('action', function (Contractor $contractor) {
                    return AppHelper::indexActionBlade($contractor, 'modules.contractors', 'contractor');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(contractors.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('type', function ($query, $keyword) {
                    $sql = "contractors.type_id IN (SELECT id FROM contractor_types as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('organ', function ($query, $keyword) {
                    $sql = "contractors.organ_id IN (SELECT id FROM contractor_organs as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // $data = Contractor::orderBy('id','DESC')->paginate(5);
        return view('contractors.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ContractorType::where('id', '!=', 4)->get()->pluck('title', 'id')->toArray();
        $organs = ContractorOrgan::pluck('title', 'id')->all();
        $regions = Region::pluck('region', 'id')->all();
        $districts = RegionDistrict::pluck('district', 'id')->all();
        $ids = RegionDistrict::all();
        $typeRelation = [];

        foreach ($ids as $value) {
            $typeRelation[] = [$value->region_id, $value->id];
        }

        return view('contractors.create', compact('types', 'organs', 'regions', 'districts', 'typeRelation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type_id' => 'required|exists:contractor_types,id',
            'organ_id' => 'required_if:type_id,text|exists:contractor_organs,id|nullable',
            'sub_organ' => 'string|max:255|nullable',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'middle_name' => 'string|max:255|nullable',
            'position' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            'email' => 'string|max:255|nullable',
            'region_id' => 'required_if:type_id,text|nullable',
            'district_id' => 'required_if:type_id,text|nullable',
        ]);

        Contractor::create($data + [
                'creator_id' => auth()->user()->id,
            ]);

        return redirect()->route('modules.contractors.index')
            ->with('success', __('Contractor created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contractor $contractor)
    {
        return view('contractors.show', compact('contractor'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contractor $contractor)
    {
        $types = ContractorType::where('id', '!=', 4)->get()->pluck('title', 'id')->toArray();
        $organs = ContractorOrgan::pluck('title', 'id')->all();

        $regions = Region::pluck('region', 'id')->all();
        $districts = RegionDistrict::pluck('district', 'id')->all();
        $ids = RegionDistrict::all();

        $typeRelation = [];

        foreach ($ids as $value) {
            $typeRelation[] = [$value->region_id, $value->id];
        }

        return view('contractors.edit', compact('contractor', 'types', 'organs', 'regions', 'districts', 'typeRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contractor $contractor)
    {
        $request->validate([
            'type_id' => 'required|exists:contractor_types,id',
            'organ_id' => 'required_if:type_id,text|exists:contractor_organs,id|nullable',
            'sub_organ' => 'string|max:255|nullable',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'middle_name' => 'string|max:255|nullable',
            'position' => 'string|max:255|nullable',
            'phone' => 'string|max:255|nullable',
            'email' => 'string|max:255|nullable',
            'region_id' => 'required_if:type_id,text|nullable',
            'district_id' => 'required_if:type_id,text|nullable',
        ]);
        $contractor->update($request->all());
        return redirect()->route('modules.contractors.index')
            ->with('success', __('Contractor updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contractor $contractor)
    {
        $contractor->delete();
        return redirect()->route('modules.contractors.index')
            ->with('success', __('Contractor deleted successfully'));;

    }

    public function ajaxGetContractors(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $contractors = Contractor::orderby('last_name', 'asc')->select('id', 'last_name', 'name', 'middle_name')
                ->where('cover', false)
                ->limit(10)->get();
        } else {
            $contractors = Contractor::orderby('last_name', 'asc')->select('id', 'last_name', 'name', 'middle_name')
                ->where('last_name', 'like', '%' . $search . '%')->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->where('cover', true)
                ->limit(10)->get();
        }

        $response = array();
        $response[] = array(
            "id" => null,
            "text" => __('Search for an item'),
        );
        foreach ($contractors as $contractor) {
            $response[] = array(
                "id" => $contractor->id,
                "text" => $contractor->last_name . ' ' . $contractor->name . ' ' . $contractor->midd_name,
            );
        }
        return response()->json($response);
    }
    public function ajaxGetCovers(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $covers = Contractor::orderby('last_name', 'asc')->select('id', 'last_name', 'name', 'middle_name')
                ->where('cover', true)
                ->limit(10)->get();
        } else {
            $covers = Contractor::orderby('last_name', 'asc')->select('id', 'last_name', 'name', 'middle_name')
                ->where('last_name', 'like', '%' . $search . '%')->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')->where('cover', true)
                ->limit(10)->get();
        }

        $response = array();
        $response[] = array(
            "id" => null,
            "text" => __('Search for an item'),
        );
        foreach ($covers as $contractor) {
            $response[] = array(
                "id" => $contractor->id,
                "text" => $contractor->last_name . ' ' . $contractor->name . ' ' . $contractor->midd_name,
            );
        }
        return response()->json($response);
    }
}
