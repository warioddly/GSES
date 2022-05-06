<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Subject;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Subject::query())
                ->addIndexColumn()
                ->addColumn('nicknames', function (Subject $subject) {
                    return $subject->nicknames->implode('nickname', ', ');
                })
                ->editColumn('user_id', function (Subject $subject) {
                    return $subject->user->vir_full_name;
                })->editColumn('created_at', function (Subject $subject) {
                    return $subject->created_at->format('d-m-Y h:i');
                })
                ->addColumn('action', function (Subject $subject) {
                    return AppHelper::indexActionBlade($subject, 'modules.subjects', 'subject');
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('subjects.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_case' => 'required|string|max:1024',
        ]);
        Subject::create($request->all() + ['user_id' => auth()->check() ? auth()->user()->id : null]);
        return redirect()->route('modules.subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @return Response
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subject $subject
     * @return View
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_case' => 'required|string|max:1024',
        ]);
        $subject->update($request->all());
        return redirect()->route('modules.subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @return RedirectResponse
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('modules.subjects.index')->with('success', 'Delete subject successful');
    }
}
