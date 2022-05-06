<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\ExpertiseArticle;
use App\Models\SubjectNickname;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ExpertiseArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ExpertiseArticle::query())
                ->addIndexColumn()
                ->editColumn('created_at', function (ExpertiseArticle $expertiseArticle) {
                    return $expertiseArticle->created_at->format('d-m-Y h:i');
                })
                ->addColumn('action', function (ExpertiseArticle $expertiseArticle) {
                    return AppHelper::indexActionBlade($expertiseArticle, 'modules.expertiseArticles', 'expertise_article');
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('simple-cruds.expertise_articles.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('simple-cruds.expertise_articles.create');
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
            'title' => 'required|string|max:255'
        ]);
        ExpertiseArticle::create($request->all());
        return redirect()->route('modules.expertiseArticles.index')->with('success', 'successful created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ExpertiseArticle $expertiseArticle
     * @return Response
     */
    public function show(ExpertiseArticle $expertiseArticle)
    {
        return view('simple-cruds.expertise_articles.show', compact('expertiseArticle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ExpertiseArticle $expertiseArticle
     * @return Response
     */
    public function edit(ExpertiseArticle $expertiseArticle)
    {
        return view('simple-cruds.expertise_articles.edit', compact('expertiseArticle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\ExpertiseArticle $expertiseArticle
     * @return Response
     */
    public function update(Request $request, ExpertiseArticle $expertiseArticle)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);
        $expertiseArticle->update($request->all());
        return redirect()->route('modules.expertiseArticles.index')->with('success', 'successful updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ExpertiseArticle $expertiseArticle
     * @return Response
     */
    public function destroy(ExpertiseArticle $expertiseArticle)
    {
        try {
            $expertiseArticle->delete();
            return redirect()->route('modules.expertiseArticles.index')->with('success', 'successful deleted');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('Before removing all article\'s expertises');
        }

    }
}
