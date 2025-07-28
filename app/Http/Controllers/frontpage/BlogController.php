<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Blog;
use Illuminate\Http\Request;
use App\Models\admin\CommentBlog;
use App\Http\Controllers\Controller;
use App\Models\admin\CommentBlogReply;

class BlogController extends Controller
{
    public function index()
    {
        $data = Blog::with('blog_comments', 'blog_comments_reply')->where('status', 1)->paginate(9);

        return view('frontpage.blog.index', compact('data'));
    }

    
    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('blog_comments', 'blog_comments_reply')->where('status', 1)->paginate(9);

            return view('frontpage.blog.fetchData.index', compact('data'))->render();
        }
    }

    public function detail($slug){
        $data = Blog::with('category')->where('slug', $slug)->first();

        if (!$data) {
            abort(404);
        }

        $decodeImg = json_decode($data->img_url);

        $previous = Blog::where('slug', '!=', $slug)->limit(2)->inRandomOrder()->get();

        $recent = Blog::where('slug', '!=', $slug)
                    ->whereNotIn('id', $previous->pluck('id'))
                    ->limit(3)
                    ->inRandomOrder()
                    ->get();

        $comment = CommentBlog::with('reply')->where('blog_id', $data->id)->get();
        $reply = CommentBlogReply::where('blog_id', $data->id)->get();

        $countComment = count($comment) + count($reply);

        return view('frontpage.blog.detail', compact('data','decodeImg','previous', 'recent', 'comment', 'countComment'));
    }

    public function fetchDataComment(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('category')->where('slug', $request->slug)->first();
            $comment = CommentBlog::with('reply')->where('blog_id', $data->id)->get();

            return view('frontpage.blog.fetchData.comment', compact('comment','data'))->render();
        }
    }

    public function comment(Request $request,$slug){
        $project = Blog::with('category')->where('slug', $slug)->first();

        $data = CommentBlog::create([
            'user_id' => 0,
            'comment_id' => 0,
            'blog_id' => $project->id,
            'contents' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been saved.',
        ]);
    }

    public function reply(Request $request,$slug){
        $project = Blog::with('category')->where('slug', $slug)->first();

        $data = CommentBlogReply::create([
            'user_id' => 0,
            'comment_id' => $request->comment_id,
            'blog_id' => $project->id,
            'contents' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been saved.',
        ]);
    }
}
