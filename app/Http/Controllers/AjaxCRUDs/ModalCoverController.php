<?php


namespace App\Http\Controllers\AjaxCRUDs;


use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\ContractorOrgan;
use App\Models\ContractorType;
use App\Models\Region;
use App\Models\RegionDistrict;
use App\Models\User;
use Illuminate\Http\Request;

class ModalCoverController extends Controller
{
    public function create()
    {
        $types = ContractorType::pluck('title', 'id')->all();
        $organs = ContractorOrgan::query()->get()->keyBy('id')->toArray();
        $regions = Region::pluck('region', 'id')->all();
        $districts = RegionDistrict::pluck('district', 'id')->all();
        $ids = RegionDistrict::all();

        $typeRelation = [];

        foreach ($ids as $value) {
            $typeRelation[] = [$value->region_id, $value->id];
        }

        return view('modal-CRUDs.contractors.createCover', compact('types', 'organs', 'regions', 'districts', 'typeRelation'));
    }

    public function store(Request $request)
    {
        if (!$request->get('organ_id') && $request->get('organ_id_text') && $request->get('type_id')) {
            $finded = ContractorOrgan::query()
                ->where('title->' . app()->getLocale(), $request->get('organ_id_text'))
                ->where('type_id', $request->get('type_id'))
                ->first();
            if ($finded) {
                $request->offsetSet('organ_id', $finded->id);
            } else {
                $organ = ContractorOrgan::create([
                    'title' => $request->get('organ_id_text'),
                    'type_id' => $request->get('type_id')
                ]);
                if ($organ) {
                    $request->offsetSet('organ_id', $organ->id);
                }
            }
        }

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
        ]);

        $data['cover'] = 1;

        $contractor = Contractor::create($data + [
                'creator_id' => auth()->user()->id,
            ]);
        return response()->json(['id' => $contractor->id, 'name' => $contractor->last_name . ' ' . $contractor->name . ' ' . $contractor->middle_name]);
    }
}
