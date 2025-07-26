<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Blog;
use App\Models\admin\Banner;
use App\Models\admin\Client;
use Illuminate\Http\Request;
use App\Models\admin\Gallery;
use App\Models\admin\Project;
use App\Models\admin\Service;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('frontpage.home.index');
    }

    public function getService(){
        $data = Service::limit(4)->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }
    
    public function getProject(){
        $data = Project::with('kategori_project')->limit(8)->orderBy('created_at','desc')->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }
    
    public function getBlog(){
        $data = Blog::with('kategori')->with('komentar_blog')->with('komentar_blog_reply')->where('status', 1)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }
    
    public function getGallery(){
        $data = Gallery::limit(4)->get();

        return response()->json([
            'data' => $data,
        ], 200);
    }
    
    public function getBanner(){
        $data = Banner::all();

        return response()->json([
            'data' => $data,
        ], 200);
    }
    
    public function count(){
        $project = Project::all();
        $blog = Blog::all();
        $client = Client::all();
        $service = Service::all();

        $data = [
            'countProject' => count($project),
            'countBlog' => count($blog),
            'countClient' => count($client),
            'countService' => count($service),
        ];

        return response()->json([
            'data' => $data,
        ], 200);
    }
}
