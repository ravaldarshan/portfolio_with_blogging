<?php

namespace App\Http\Controllers\frontpage;

use Illuminate\Http\Request;
use App\Models\admin\Project;
use App\Http\Controllers\Controller;
use App\Models\admin\KategoriProject;
use App\Models\admin\KomentarProject;
use App\Models\admin\KomentarProjectReply;

class ProjectController extends Controller
{
    public function index(){
        $kategori = KategoriProject::all();

        $project = Project::with('kategori_project')->paginate(9);

        return view('frontpage.project.index', compact('kategori', 'project'));
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $kategori = KategoriProject::all();

            $project = Project::with('kategori_project')->paginate(9);

            return view('frontpage.project.fetchData.index', compact('kategori', 'project'))->render();
        }
    }

    public function detail($slug){
        $data = Project::with('kategori_project')->where('slug', $slug)->first();

        if (!$data) {
            abort(404);
        }

        $decodeImg = json_decode($data->img_url);

        $previous = Project::where('slug', '!=', $slug)->limit(2)->inRandomOrder()->get();

        $recent = Project::where('slug', '!=', $slug)
                    ->whereNotIn('id', $previous->pluck('id'))
                    ->limit(3)
                    ->inRandomOrder()
                    ->get();

        $comment = KomentarProject::with('reply')->where('project_id', $data->id)->get();
        $reply = KomentarProjectReply::where('project_id', $data->id)->get();

        $countComment = count($comment) + count($reply);

        return view('frontpage.project.detail', compact('data','decodeImg','previous', 'recent', 'comment', 'countComment'));
    }

    public function fetchDataComment(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::with('kategori_project')->where('slug', $request->slug)->first();
            $comment = KomentarProject::with('reply')->where('project_id', $data->id)->get();

            return view('frontpage.project.fetchData.comment', compact('comment','data'))->render();
        }
    }

    public function comment(Request $request,$slug){
        $project = Project::with('kategori_project')->where('slug', $slug)->first();

        $data = KomentarProject::create([
            'user_id' => 0,
            'komentar_id' => 0,
            'project_id' => $project->id,
            'isi' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah disimpan.',
        ]);
    }

    public function reply(Request $request,$slug){
        $project = Project::with('kategori_project')->where('slug', $slug)->first();

        $data = KomentarProjectReply::create([
            'user_id' => 0,
            'komentar_id' => $request->komentar_id,
            'project_id' => $project->id,
            'isi' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah disimpan.',
        ]);
    }
}
