<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function create(){
        return view('teachers.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'age' => 'required|integer',
            'sex' => 'required|in:male,female',
        ]);

        /** Handle image upload */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); /** Append timestamp to image name */
            $imagePath = $image->storeAs('teacher_images', $imageName);
        }
        
        /** Using try catch error handling */
        try{
            Teacher::create(['name' =>  htmlentities($request->name), 'age' =>  htmlentities($request->age), 'sex' =>  htmlentities($request->sex), 'image' => $imageName]);
        } catch (QueryException $e) {   
            Log::error('Error in add teacher: ' . $e->getMessage());
        }
        
        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully');
    }

    public function index(){
        return view('teachers.listing', ['pageTitle' => 'Teacher Listing']);
    }

    public function filter(Request $request){
        if ($request->ajax()) {
            $formatuserdata = Teacher::getTeacherFilterdData($request->all());
            return response()->json($formatuserdata);
        }
    }
}
