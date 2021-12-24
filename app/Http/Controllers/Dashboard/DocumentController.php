<?php

namespace App\Http\Controllers\Dashboard;

use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            $documents = auth()->user()->documents;
            return response()->json($documents);
        }
        return view('dashboard.documents.index');
    }


    public function create()
    {
        return view('dashboard.documents.create');
    }


    public function edit(Document $document)
    {
        return view('dashboard.documents.edit',compact('document'));
    }

    public function update(Request $request, Document $document)
    {

        $request->validate([
            'end_date' => 'required',
            'noti_expiry' => 'required'
        ]);


        if($request->file('file') != ''){
            $fileName = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/documents/', $fileName);
            $document->file_name = $fileName;
            
        }

        $document->start_date = $request->start_date;
        $document->end_date = $request->end_date;
        $document->noti_expiry = $request->noti_expiry;

        $document->save();

        return redirect(route('dashboard.documents.edit', $document));
    }


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'end_date' => 'required',
            'noti_expiry' => 'required'
        ]);
        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('public/documents/', $fileName);

        auth()->user()->documents()->create([
            'file_name' => $fileName,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'noti_expiry' => $request->noti_expiry,
        ]);

        return response()->json([
            'status' => 1
        ]);
    }

    public function destroy(Document $document)
    {
        if($document->documentable_id == auth()->user()->id){
            $document->delete();
        }
        return response()->json([
            'status' => 1
        ]);
    }

    public function download(Document $document)
    {
        return Storage::download('/public/documents/' . $document->file_name);
    }
}
