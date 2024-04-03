<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Students, Classes};
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class StudentsController extends Controller
{
    public function create(){
        $classes = Classes::pluck('name', 'id'); /** Assuming 'name' column is used for class names */
        return view('students.create', compact('classes'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'class_id' => 'required|string',
            'roll_number' => 'required|integer',
        ]);
        
        /** Handle image upload */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); /** Append timestamp to image name */
            $image->storeAs('student_images', $imageName);
        }

        /** Using try catch error handling */
        try{
            Students::create(['name' =>  htmlentities($request->input('name')), 'age' =>  htmlentities($request->input('age')), 'image' => $imageName, 'class_id' =>  $request->input('class_id'), 'roll_number' =>  htmlentities($request->input('roll_number'))]);
        } catch (QueryException $e) {   
            Log::error('Error in add student: ' . $e->getMessage());
        }

        return redirect()->route('students.index')->with('success', 'Student added successfully');
    }

    public function index(){
        return view('students.listing', ['pageTitle' => 'Student Listing']);
    }

    public function filter(Request $request){
        if ($request->ajax()) {
            $formatuserdata = Students::getStudentFilterdData($request->all());
            return response()->json($formatuserdata);
        }
    }
}
