<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Subject;
use App\Models\SubjectNickname;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SubjectNicknameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SubjectNickname::query())
                ->addIndexColumn()
                ->editColumn('subject_id',function (SubjectNickname $nickname){
                  return $nickname->subject->subject_case;
                })
                ->editColumn('user_id', function (SubjectNickname $nickname) {
                    return $nickname->user->vir_full_name;
                })
                ->editColumn('created_at', function (SubjectNickname $nickname) {
                    return $nickname->created_at->format('d-m-Y h:i');
                })
                ->addColumn('action', function (SubjectNickname $nickname) {
                    return AppHelper::indexActionBlade($nickname, 'modules.nicknames', 'nickname');
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('nicknames.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $subjects = Subject::pluck('subject_case', 'id')->all();
        return view('nicknames.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nickname' => 'required|string|max:1024',
            'subject_id'=>'required|exists:subjects,id'
        ]);
        SubjectNickname::create($request->all() + ['user_id' => auth()->check() ? auth()->user()->id : null]);
        return redirect()->route('modules.nicknames.index');
    }

    /**
     * Display the specified resource.
     *
     * @param SubjectNickname $nickname
     * @return View
     */
    public function show(SubjectNickname $nickname): View
    {
        return view('nicknames.edit', compact('nickname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SubjectNickname $nickname
     * @return Application|Factory|View
     */
    public function edit(SubjectNickname $nickname)
    {
        $subjects = Subject::pluck('subject_case', 'id')->all();
        return view('nicknames.edit', compact('subjects', 'nickname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubjectNickname $nickname
     * @return RedirectResponse
     */
    public function update(Request $request, SubjectNickname $nickname)
    {
        $request->validate([
            'nickname' => 'required|string|max:1024',
            'subject_id'=>'required|exists:subjects,id'
        ]);
        $nickname->update($request->all());
        return redirect()->route('modules.nicknames.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubjectNickname $subjectNickname
     * @return RedirectResponse
     */
    public function destroy(SubjectNickname $subjectNickname)
    {
        $subjectNickname->delete();
        return redirect()->route('modules.nicknames.index');
    }
}
