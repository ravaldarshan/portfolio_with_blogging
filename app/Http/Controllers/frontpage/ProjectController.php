<?php

namespace App\Http\Controllers\frontpage;

use Illuminate\Http\Request;
use App\Models\admin\Project;
use App\Http\Controllers\Controller;
use App\Models\admin\CategoryProject;
use App\Models\admin\CommentProject;
use App\Models\admin\CommentProjectReply;

class ProjectController extends Controller
{
    public function index(){
        $category = CategoryProject::all();

        $project = Project::with('category_project')->paginate(9);

        return view('frontpage.project.index', compact('category', 'project'));
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $category = CategoryProject::all();

            $project = Project::with('category_project')->paginate(9);

            return view('frontpage.project.fetchData.index', compact('category', 'project'))->render();
        }
    }

    public function detail($slug){
        $data = Project::with('category_project')->where('slug', $slug)->first();

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

        $comment = CommentProject::with('reply')->where('project_id', $data->id)->get();
        $reply = CommentProjectReply::where('project_id', $data->id)->get();

        $countComment = count($comment) + count($reply);

        return view('frontpage.project.detail', compact('data','decodeImg','previous', 'recent', 'comment', 'countComment'));
    }

    public function fetchDataComment(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::with('category_project')->where('slug', $request->slug)->first();
            $comment = CommentProject::with('reply')->where('project_id', $data->id)->get();

            return view('frontpage.project.fetchData.comment', compact('comment','data'))->render();
        }
    }

    public function comment(Request $request,$slug){
        $project = Project::with('category_project')->where('slug', $slug)->first();

        $data = CommentProject::create([
            'user_id' => 0,
            'comment_id' => 0,
            'project_id' => $project->id,
            'contents' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been saved.',
        ]);
    }

    public function reply(Request $request,$slug){
        $project = Project::with('category_project')->where('slug', $slug)->first();

        $data = CommentProjectReply::create([
            'user_id' => 0,
            'comment_id' => $request->comment_id,
            'project_id' => $project->id,
            'contents' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been saved.',
        ]);
    }
}
