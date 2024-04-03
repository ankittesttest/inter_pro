<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SidebarController extends Controller{
    public function index(){
        return view('dashboard'); // Assuming you have a welcome.blade.php file for your homepage
    }

}
