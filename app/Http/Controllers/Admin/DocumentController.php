<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png|max:10240', // 10MB
            'document_type' => 'required',
            'access_level' => 'required',
        ]);

        $file = $request->file('document_file');
        $path = $file->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'file_extension' => $file->getClientOriginalExtension(),
            'uploaded_by' => Auth::id(),
            'access_level' => $request->access_level,
            'category' => $request->category,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document)
    {
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_extension);
    }

    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }
}
