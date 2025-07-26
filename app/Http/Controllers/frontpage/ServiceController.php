<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Client;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(){
        $service = Service::get()->toArray();
        
        $service = array_column($service, 'value', 'name');

        return view('frontpage.service.index', compact('service'));
    }

    public function getService(){
        $data = Service::all();

        return response()->json([
            'data' => $data,
        ], 200);
    }

    
    public function getClient(){
        $data = Client::all();

        return response()->json([
            'data' => $data,
        ], 200);
    }
}
