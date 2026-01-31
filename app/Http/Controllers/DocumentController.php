<?php

namespace App\Http\Controllers;

use App\Events\DocumentUploaded;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{



    public function index(){
        $documents = Document::latest()->get();
        return view('documents.index', compact('documents'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $file = $request->file('file');

        $storedPath = $file->store('documents');

        $document = Document::create([
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedPath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'status' => 'pending',
        ]);

        event(new DocumentUploaded($document));

        return response()->json([
            'message' => ' Docuent uploaded and queued for processing',
            'document_id' => $document->id,
        ]);
    }
}
