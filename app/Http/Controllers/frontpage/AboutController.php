<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\About;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index(){
        return view('frontpage.about.index');
    }

    public function getService(){
        $data = Service::limit(2)->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function getAbout(){
        $data = About::all();

        return response()->json([
            'data' => $data,
        ], 200);
    }
}
