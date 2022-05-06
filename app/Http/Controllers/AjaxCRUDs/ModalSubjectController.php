<?php


namespace App\Http\Controllers\AjaxCRUDs;


use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\ContractorOrgan;
use App\Models\ContractorType;
use App\Models\Subject;
use Illuminate\Http\Request;

class ModalSubjectController extends Controller
{
    public function create()
    {
        return view('modal-CRUDs.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_case' => 'required|string|max:1024',
        ]);

        $subject = Subject::create($request->all() + [
                'user_id' => auth()->user()->id,
            ]);
        return response()->json(['id' => $subject->id, 'subject_case' => $subject->subject_case]);
    }
}
