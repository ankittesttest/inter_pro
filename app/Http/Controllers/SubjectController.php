<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\{Subject, Classes, Language};

class SubjectController extends Controller
{
    public function create(){
        $classes = Classes::pluck('name', 'id'); /** Assuming 'name' column is used for class names */
        $language = Language::pluck('languag_name', 'id');
        return view('subjects.create', ['classes' => $classes, 'language' => $language]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'languages' => 'required|array',
            'languages.*' => 'exists:languages,id',
        ]);

        /** Using try catch error handling */
        try{
            $subject = new Subject();
            $subject->name =  htmlentities($request->name);
            $subject->class_id = $request->class_id;
            $subject->save();

            $subject->languages()->sync($request->languages);
        } catch (QueryException $e) {   
            Log::error('Error in add subject: ' . $e->getMessage());
        }

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully');
    }

    public function index(){
        return view('subjects.listing', ['pageTitle' => 'Subject Listing']);
    }

    public function filter(Request $request){
        if ($request->ajax()) {
            $formatuserdata = Subject::getSubjectsFilterdData($request->all());
            return response()->json($formatuserdata);
        }
    }
}
