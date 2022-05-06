<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function download($name_uuid)
    {
        $document = Document::where(['name_uuid' => $name_uuid])->first();
        if (empty($document))
            return response()->json(['message' => 'Not Found!'], 404);
        return response()->download($document->getRealPath(), $document->name);
    }

    public function view($name_uuid){
        $document = Document::where(['name_uuid' => $name_uuid])->first();
        if (empty($document))
            return response()->json(['message' => 'Not Found!'], 404);
        return response()->file($document->getRealPath());
    }
}
