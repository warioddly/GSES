<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\DocumentTemplateStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DocumentTemplate::query();
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y'); // human readable format
                })
                ->addColumn('document', function (DocumentTemplate $template) {
                    return AppHelper::showBlade('', $template->document()->first());
                })
                ->addColumn('status', function (DocumentTemplate $template) {
                    return $template->status()->value('title');
                })
                ->addColumn('creator', function (DocumentTemplate $template) {
                    return $template->creator()->value(DB::raw("CONCAT_WS(' ', last_name, name, middle_name)"));
                })
                ->addColumn('action', function (DocumentTemplate $template) {
                    return AppHelper::indexActionBlade($template, 'modules.templates', 'template');
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $sql = "DATE_FORMAT(document_templates.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('document', function ($query, $keyword) {
                    $sql = "document_templates.document_id IN (SELECT id FROM documents as t WHERE t.name LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $sql = "document_templates.status_id IN (SELECT id FROM document_template_status as t WHERE t.title LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('creator', function ($query, $keyword) {
                    $sql = "document_templates.creator_id IN (SELECT id FROM users as t WHERE t.name LIKE ?)";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // $data = DocumentTemplate::orderBy('id','DESC')->paginate(5);
        return view('templates.index')
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::pluck('name', 'id')->all();
        $statuses = DocumentTemplateStatus::pluck('title', 'id')->all();
        return view('templates.create', compact('documents', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status_id' => 'required|exists:document_template_status,id',
        ]);
        $input = $request->all();

        $input['document_id'] = AppHelper::saveDocument('document', 'templates');
        $input['creator_id'] = auth()->id();

        DocumentTemplate::create($input);
        return redirect()->route('modules.templates.index')
            ->with('success', __('Report created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentTemplate $template)
    {
        return view('templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentTemplate $template)
    {
        $documents = Document::pluck('name', 'id')->all();
        $statuses = DocumentTemplateStatus::pluck('title', 'id')->all();
        return view('templates.edit', compact('documents', 'statuses', 'template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentTemplate $template)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status_id' => 'required|exists:document_template_status,id',
        ]);
        $input = $request->all();

        // Upload file
        if (empty($input['document_id'])) {
            $input['document_id'] = AppHelper::saveDocument('document', 'templates');
        }

        $template->update($input);
        return redirect()->route('modules.templates.index')
            ->with('success', __('Report updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentTemplate $template)
    {
        $template->delete();
        return redirect()->route('modules.templates.index')
            ->with('success', __('Report deleted successfully'));
    }
}
